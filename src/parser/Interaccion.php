<?php

namespace TrabajoTarjeta\Parser;

use TrabajoTarjeta\Tarjeta;

abstract class Interaccion {
	const INTERACCION_PAGO = 0;
	const INTERACCION_CARGA = 1;

	private $tiempo;

	public function __construct( int $tiempo ) {
		$this->tiempo = $tiempo;
	}

	public abstract function correrInteraccion( Tarjeta $tarjeta );

	public function getTiempo(): int {
		return $this->tiempo;
	}
}