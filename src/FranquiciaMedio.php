<?php

namespace TrabajoTarjeta;

class FranquiciaMedio extends Tarjeta {

	private $pagosHoy = 0;

	public function getPrecio( int $tiempo, ColectivoInterface $colectivo ): Precio {
		global $PRECIO_MEDIO_BOLETO;
		global $PRECIO_RELATIVO_TRANSBORDO;

		if ( $this->pagosHoy >= 2 && TiempoAyudante::pertenecenAlMismoDia( $this->getUltTiempo(), $tiempo ) ) {
			return parent::getPrecio( $tiempo, $colectivo );
		}

		$noSePuede = $tiempo - $this->getUltTiempo() < TiempoAyudante::CINCO_MINUTOS;

		if ( $this->estransbordo( $tiempo, $colectivo->linea(), $colectivo->numero() ) ) {
			return new Precio( $noSePuede, $PRECIO_MEDIO_BOLETO * $PRECIO_RELATIVO_TRANSBORDO, TipoDeBoleto::Trans );
		}

		return new Precio( $noSePuede, $PRECIO_MEDIO_BOLETO, TipoDeBoleto::Medio );
	}

	protected function alFinalizarPago( int $tiempo ) {
		if ( !TiempoAyudante::pertenecenAlMismoDia( $this->getUltTiempo(), $tiempo ) ) {
			$this->pagosHoy = 1;
		} else {
			$this->pagosHoy++;
		}

		parent::alFinalizarPago( $tiempo );
	}
}
