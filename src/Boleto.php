<?php

namespace TrabajoTarjeta;

class Boleto implements BoletoInterface {

	private $colectivo;
	private $tarjeta;
	private $pago;
	private $tiempo;
	private $saldo;

	public function __construct( ColectivoInterface $colectivo, TarjetaInterface $tarjeta, int $tiempo,
								 Pago $pago ) {
		$this->pago = $pago;
		$this->colectivo = $colectivo;
		$this->tarjeta = $tarjeta;
		$this->tiempo = $tiempo;
		$this->saldo = $this->tarjeta->obtenerSaldo();
	}

	/**
	 * Devuelve el valor del boleto.
	 *
	 * @return int
	 */
	public function obtenerValor() {
		return $this->pago->PRECIO->PRECIO;
	}

	/**
	 * Devuelve un objeto que respresenta el colectivo donde se viajó.
	 *
	 * @return ColectivoInterface
	 */
	public function obtenerColectivo() {
		return $this->colectivo;
	}

	public function obtenerTarjeta(): TarjetaInterface {
		return $this->tarjeta;
	}

	public function obtenerFechaYHora(): int {
		return $this->tiempo;
	}

	public function obtenerTipoDeBoleto(): string {
		return $this->pago->TIPO_BOLETO;
	}

	public function obtenerSaldo(): float {
		return $this->saldo;
	}

	public function esViajePlus(): bool {
		return $this->pago->ES_PLUS;
	}

	public function extras(): array {
		return $this->pago->EXTRAS;
	}
}
