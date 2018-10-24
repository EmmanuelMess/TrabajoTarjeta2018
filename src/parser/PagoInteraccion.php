<?php

namespace TrabajoTarjeta\Parser;


use TrabajoTarjeta\Tarjeta;

class PagoInteraccion extends Interaccion {
	public function __construct( int $tiempo ) {
		parent::__construct( $tiempo );
	}

	public function correrInteraccion( Tarjeta $tarjeta ) {
		$tarjeta->disminuirSaldo();
	}
}