<?php

use PHPUnit\Framework\TestCase;
use TrabajoTarjeta\Parser\CargaInteraccion;
use TrabajoTarjeta\Parser\Interaccion;
use TrabajoTarjeta\Parser\PagoInteraccion;
use TrabajoTarjeta\Parser\Parser;
use TrabajoTarjeta\Tarjeta;

class ParserTest extends TestCase {
	public function testTarjeta() {
		$this->assertInstanceOf( Tarjeta::class, $this->crearTarjeta( Parser::TARJETA_NORMAL, 22 ) );
		$this->assertInstanceOf( Tarjeta::class, $this->crearTarjeta( Parser::TARJETA_MEDIO, 22 ) );
		$this->assertInstanceOf( Tarjeta::class, $this->crearTarjeta( Parser::TARJETA_COMPLETO, 22 ) );
	}

	private function crearTarjeta( int $tipo, int $id ): Tarjeta {
		$json =
			"{
                \"TarjetaInicial\": {
                    \"Tipo\": " . $tipo . ",
                    \"Id\": " . $id . "
                },
                \"Interacciones\": []
            }";

		$reciever = new Parser( $json );

		return $reciever->getTarjeta();
	}

	const CARGA_NULA = -9999999999;

	public function testInteraccionPago() {
		$tiempo = 5555555;
		$interaccion = $this->crearInteraccion( Interaccion::INTERACCION_PAGO, ParserTest::CARGA_NULA, $tiempo );
		$this->assertInstanceOf( PagoInteraccion::class, $interaccion );
		$this->assertEquals( $tiempo, $interaccion->getTiempo() );
	}

	public function testInteraccionRecarga() {
		$saldo = 10;
		$tiempo = 5555555;
		$interaccion = $this->crearInteraccion( Interaccion::INTERACCION_CARGA, $saldo, $tiempo );
		$this->assertInstanceOf( CargaInteraccion::class, $interaccion );
		$this->assertEquals( $saldo, $interaccion->getCarga() );
		$this->assertEquals( $tiempo, $interaccion->getTiempo() );
	}

	private function crearInteraccion( int $tipo, float $carga, int $tiempo ): Interaccion {
		$json =
			"{
                \"TarjetaInicial\": {
                    \"Tipo\": " . Parser::TARJETA_NORMAL . ",
                    \"Id\": 20
                }, 
                \"Interacciones\": [
                    {
                        \"Tipo\": " . $tipo . ",";

		if ( $carga != ParserTest::CARGA_NULA ) {
			$json = $json .
				"\"Carga\": " . $carga . ",";
		}

		$json = $json .
			"          \"Tiempo\": " . $tiempo . "
                    }
                ]
            }";

		$reciever = new Parser( $json );

		return $reciever->getInteracciones()[0];
	}
}