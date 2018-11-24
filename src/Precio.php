<?php

namespace TrabajoTarjeta;


class Precio {
	public $NO_SE_PUEDE;
	public $PRECIO;
	public $TIPO;

	public function __construct( bool $noSePuede, float $precio, string $tipo ) {
		$this->NO_SE_PUEDE = $noSePuede;
		$this->PRECIO = $precio;
		$this->TIPO = $tipo;
	}

}