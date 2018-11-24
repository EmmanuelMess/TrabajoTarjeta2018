<?php

use PHPUnit\Framework\TestCase;
use function TrabajoTarjeta\Parser\correrSimulacion;
use TrabajoTarjeta\Parser\Interaccion;
use TrabajoTarjeta\Parser\Parser;

class SimulacionTest extends TestCase {

	public function testSimulacionSimple() {
		$json =
			"{
                \"TarjetaInicial\": {
                    \"Tipo\": " . Parser::TARJETA_NORMAL . ",
                    \"Id\": 20
                }, 
                \"Interacciones\": [
                    {
                        \"Tipo\": " . Interaccion::INTERACCION_CARGA . ",
                        \"Carga\": 10,
                        \"Tiempo\": 42
                    }
                ]
            }";

		$jsonSimulado = correrSimulacion($json);
		$jsonSupesto =
			"[".
				"{".
				"\"Tiempo\":42,".
				"\"Saldo\":10,".
				"\"Diferencia\":10,".
				"\"Mensaje\":\"\"".
				"}".
			"]";


		$this->assertEquals( $jsonSupesto, $jsonSimulado );
	}
}