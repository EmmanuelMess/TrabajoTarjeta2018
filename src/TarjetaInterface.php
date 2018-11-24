<?php

namespace TrabajoTarjeta;

interface TarjetaInterface {

	/**
	 * Recarga una tarjeta con un cierto valor de dinero.
	 *
	 * @param float $monto
	 *
	 * @return bool
	 *   Devuelve TRUE si el monto a cargar es válido, o FALSE en caso de que no
	 *   sea valido.
	 */
	public function recargar( $monto, int $tiempo );

	/**
	 * Devuelve el saldo que le queda a la tarjeta.
	 *
	 * @return float
	 */
	public function obtenerSaldo(): float;

	/**
	 * Precio del boleto
	 */
	public function getPrecio( int $tiempo, ColectivoInterface $colectivo ): Precio;

	public function generarPago( int $tiempo, ColectivoInterface $colectivo ): Pago;

}
