<?php

namespace TrabajoTarjeta;

class Pago {
	public $FALLO;
	public $PRECIO;
	public $ES_PLUS;
	public $EXTRAS;

	public static function newFallado(): Pago {
		return new Pago( true, new Precio( false, 0, "" ), false );
	}

	public function __construct( bool $fallo, Precio $precio, bool $esPlus, array $extras = [] ) {
		$this->FALLO = $fallo;
		$this->PRECIO = $precio;
		$this->ES_PLUS = $esPlus;
		$this->EXTRAS = $extras;
	}
}