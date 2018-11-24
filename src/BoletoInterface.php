<?php

namespace TrabajoTarjeta;

interface BoletoInterface {

	/**
	 * Devuelve el valor del boleto.
	 *
	 * @return int
	 */
	public function obtenerValor();

	/**
	 * Devuelve un objeto que respresenta el colectivo donde se viajó.
	 *
	 * @return ColectivoInterface
	 */
	public function obtenerColectivo();

	public function obtenerTarjeta(): TarjetaInterface;

	public function obtenerFechaYHora(): int;

	public function obtenerTipoDeBoleto(): string;

	public function obtenerSaldo(): float;

	public function esViajePlus(): bool;

	public function extras(): array;

}
