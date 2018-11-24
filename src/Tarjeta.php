<?php

namespace TrabajoTarjeta;

class Tarjeta implements TarjetaInterface {
	protected $saldo = 0;
	protected $boletosPlusUsados = 0;
	protected $ultTiempo = -TiempoAyudante::CINCO_MINUTOS - 1;
	protected $transbordo;
	protected $linea = '';
	protected $bandera = '';

	public function __construct() {
		$this->transbordo = 0;
	}

	public function estransbordo( $montotiempo, $lineacole, $banderacole ) {
		global $DIASFERIADOS;
		$diasferiados = $DIASFERIADOS;
		if ( $lineacole != $this->linea || $banderacole != $this->bandera ) {

			$this->linea = $lineacole;
			$this->bandera = $banderacole;

			if ( $this->transbordo == 0 ) {
				$this->transbordo = $montotiempo;
				return false;
			}

			$tiempoayuda = new TiempoAyudante();
			$tiempopago = $montotiempo;
			$tolerancia = $this->transbordo;

			$horapago1 = $tiempoayuda->saber_hora( $this->transbordo );
			$horapago2 = $tiempoayuda->saber_hora( $tiempopago );

			$diapago1 = $tiempoayuda->saber_dia( $this->transbordo );//necesitaria un dia pago prima de formato 2018-09-19 por ejemplo
			$diapagoferiado = $tiempoayuda->saber_dia_md( $this->transbordo );
			$diapago1prima = $tiempoayuda->saber_dia_ymd( $this->transbordo );

			$diapago2prima = $tiempoayuda->saber_dia_ymd( $tiempopago );
			$diapago2 = $tiempoayuda->saber_dia( $tiempopago );

			if ( $horapago1 > "22:00:00" || $horapago1 < "06:00:00" ) {

				$tolerancia += (90 * 60);
				$tolerancia = $tiempoayuda->saber_hora( $tolerancia );
				$this->transbordo = 0;
				return $this->verificar( $horapago2, $tolerancia );
			}

			if ( $diapago1 == "Lunes" || $diapago1 == "Martes" || $diapago1 == "Miercoles" || $diapago1 == "Jueves" || $diapago1 == "Viernes" ) {
				if ( $horapago1 >= "06:00:00" && $horapago1 <= "22:00:00" && $diapago1 == $diapago2 && $diapago1prima == $diapago2prima ) {
					$tolerancia += (60 * 60);
					$tolerancia = $tiempoayuda->saber_hora( $tolerancia );
					$this->transbordo = 0;
					return $this->verificar( $horapago2, $tolerancia );
				}
			}

			if ( $diapago1 == "Sabado" ) {
				if ( $horapago1 >= "06:00:00" && $horapago1 <= "14:00:00" && $diapago1 == $diapago2 && $diapago1prima == $diapago2prima ) {
					$tolerancia += 60 * 60;
					$tolerancia = $tiempoayuda->saber_hora( $tolerancia );
					$this->transbordo = 0;
					return $this->verificar( $horapago2, $tolerancia );
				}
				if ( $horapago1 > "14:00:00" && $horapago1 <= "22:00:00" && $diapago1 == $diapago2 && $diapago1prima == $diapago2prima ) {
					$tolerancia += 90 * 60;
					$tolerancia = $tiempoayuda->saber_hora( $tolerancia );
					$this->transbordo = 0;
					return $this->verificar( $horapago2, $tolerancia );
				}
			}

			if ( $diapago1 == "Domingo" || in_array( $diapagoferiado, $diasferiados ) ) {
				if ( $horapago1 >= "06:00:00" && $horapago1 <= "22:00:00" && $diapago1 == $diapago2 && $diapago1prima == $diapago2prima ) {
					$tolerancia += 90 * 60;
					$tolerancia = $tiempoayuda->saber_hora( $tolerancia );
					$this->transbordo = 0;
					return $this->verificar( $horapago2, $tolerancia );
				}
			}
		} else {
			return false;
		}
	}


	public function verificar( $horapago2, $tolerancia ) {
		if ( $horapago2 <= $tolerancia ) {
			return true;
		} else {
			return false;
		}
	}


	public function recargar( $monto, int $tiempo ) {
		global $VALORES_CARGABLES;

		if ( !$VALORES_CARGABLES->contains( (float)$monto ) ) return false;
		$this->saldo += valorCargado( (float)$monto );
		return true;
	}

	public function obtenerSaldo(): float {
		return $this->saldo;
	}

	public function generarPago( int $tiempo, ColectivoInterface $colectivo ): Pago {
		$pago = $this->manejarPago( $tiempo, $colectivo );

		if ( !$pago->FALLO ) {
			$this->alFinalizarPago( $tiempo );
		}

		return $pago;
	}

	protected function alFinalizarPago( int $tiempo ) {
		$this->ultTiempo = $tiempo;
	}

	private function manejarPago( int $tiempo, ColectivoInterface $colectivo ): Pago {
		global $MAX_PLUS;

		if ( $this->getPrecio( $tiempo, $colectivo )->NO_SE_PUEDE ) {
			return Pago::newFallado();
		}

		if ( $this->getPrecio( $tiempo, $colectivo )->PRECIO == 0 ) {
			return new Pago( false, $this->getPrecio( $tiempo, $colectivo ), false );
		}

		if ( $this->obtenerSaldo() - $this->getPrecio( $tiempo, $colectivo )->PRECIO < 0 ) {
			if ( $this->boletosPlusUsados >= $MAX_PLUS ) return Pago::newFallado();

			$this->boletosPlusUsados++;
			return new Pago( false, $this->getPrecio( $tiempo, $colectivo ), true );
		}

		$extra = [];

		if ( $this->boletosPlusUsados > 0 ) {
			$boletosPlusAPagar = ($this->boletosPlusUsados) * $this->getPrecio( $tiempo, $colectivo )->PRECIO;

			if ( $this->estransbordo( $tiempo, $colectivo->linea(), $colectivo->numero() ) ) {
				$extra[] = "Transbordo";
			}

			if ( $this->saldo - $boletosPlusAPagar + $this->getPrecio( $tiempo, $colectivo )->PRECIO < 0 ) {
				return Pago::newFallado();
			}

			$this->saldo -= $boletosPlusAPagar;
			$this->boletosPlusUsados = 0;

			$extra[] = "Abona viajes plus $" . ($boletosPlusAPagar);
		}

		$this->saldo -= $this->getPrecio( $tiempo, $colectivo )->PRECIO;
		return new Pago( false, $this->getPrecio( $tiempo, $colectivo ), false, $extra );
	}

	public function getPrecio( int $tiempo, ColectivoInterface $colectivo ): Precio {
		global $PRECIO_VIAJE;
		global $PRECIO_RELATIVO_TRANSBORDO;

		if ( $this->estransbordo( $tiempo, $colectivo->linea(), $colectivo->numero() ) ) {
			return new Precio( false, $PRECIO_VIAJE * $PRECIO_RELATIVO_TRANSBORDO, TipoDeBoleto::Trans );
		}

		return new Precio( false, $PRECIO_VIAJE, TipoDeBoleto::Normal );
	}

	protected function getUltTiempo(): int {
		return $this->ultTiempo;
	}
}
