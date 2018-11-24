<?php

namespace TrabajoTarjeta\Parser;

use InvalidArgumentException;
use \TrabajoTarjeta\Tarjeta;
use \TrabajoTarjeta\FranquiciaMedio;
use \TrabajoTarjeta\FranquiciaCompleta;

class Parser {

	const TARJETA_NORMAL = 0;
	const TARJETA_MEDIO = 1;
	const TARJETA_COMPLETO = 2;

	private $tarjeta;
	private $interacciones;

	public function __construct( string $json ) {
		$decoded = json_decode( $json );
		if ( $decoded === null ) throw new InvalidArgumentException( "Json invalido!" );

		$this->tarjeta = $this->createTarjeta( $decoded->TarjetaInicial->Tipo, $decoded->TarjetaInicial->Id );
		$this->interacciones = [];

		foreach ( $decoded->Interacciones as $interaccion ) {
			$this->interacciones[] = $this->crearInteraccion( $interaccion );
		}
	}

	private function createTarjeta( int $tipo, int $id ): Tarjeta {
		switch ( $tipo ) {
			case Parser::TARJETA_NORMAL:
				return new Tarjeta;
			case Parser::TARJETA_MEDIO:
				return new FranquiciaMedio;
			case Parser::TARJETA_COMPLETO:
				return new FranquiciaCompleta;
			default:
				throw new InvalidArgumentException( $tipo . " es invalido!" );
		}
	}


	private function crearInteraccion( $interaccion ): Interaccion {
		switch ( $interaccion->Tipo ) {
			case Interaccion::INTERACCION_PAGO:
				return new PagoInteraccion( $interaccion->Tiempo );
			case Interaccion::INTERACCION_CARGA:
				return new CargaInteraccion( $interaccion->Carga, $interaccion->Tiempo );
			default:
				throw new InvalidArgumentException( $interaccion->Tipo . " es invalido!" );
		}
	}

	public function getTarjeta(): Tarjeta {
		return $this->tarjeta;
	}

	public function getInteracciones(): array {
		return $this->interacciones;
	}
}