<?php

namespace TrabajoTarjeta\Parser;


use TrabajoTarjeta\Tarjeta;

class CargaInteraccion extends Interaccion {

	private $carga;

	public function __construct( float $carga, int $tiempo ) {
		parent::__construct( $tiempo );

		$this->carga = $carga;
	}

	public function correrInteraccion( Tarjeta $tarjeta ) {
		$tarjeta->recargar( $this->carga, $this->getTiempo() );
	}

	//DE ACA PARA TESTS -----------------------------------------------

	public function getCarga() {
		return $this->carga;
	}
}