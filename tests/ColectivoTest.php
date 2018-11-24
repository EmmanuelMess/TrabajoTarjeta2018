<?php

namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;

class ColectivoTest extends TestCase {

	/**
	 * Comprueba que se devuelvan los parametros correctos en Colectivo
	 */

	public function testLineaEmpresaNumero() {
		$linea = "143 Roja";
		$numero = 13;
		$empresa = "Rosario Bus";

		$colectivo = new Colectivo( $linea, $empresa, $numero );

		$this->assertEquals( $linea, $colectivo->linea() );
		$this->assertEquals( $numero, $colectivo->numero() );
		$this->assertEquals( $empresa, $colectivo->empresa() );
	}

	/**
	 * Comprueba que a partir de 3 tarjetas distintas ya cargadas con un saldo de $50 y 3 boletos que ya fueron testeados es sus campos, se convalide que las funciones de colectivo devuelva un boleto correcto dependiendo
	 *    de la tarjeta y ademas disminuya su saldo
	 */

	public function testPagarcon() {
		global $PRECIO_VIAJE;
		global $PRECIO_MEDIO_BOLETO;

		$valorsaldo = 50.;

		$linea = '107 Fonavi';
		$empresa = 'Rosario Bus';
		$numero = 13;

		$tarjeta = new Tarjeta;
		$tarjeta->recargar( $valorsaldo, 0 );

		$colectivo = new Colectivo( $linea, $empresa, $numero );

		$boleto = $colectivo->pagarCon( $tarjeta, 0 );

		$this->assertEquals( $colectivo, $boleto->obtenerColectivo() );
		$this->assertEquals( $tarjeta->obtenerSaldo(), $boleto->obtenerSaldo() );
		$this->assertEquals( $PRECIO_VIAJE, $boleto->obtenerValor() );
		$this->assertEquals( 0, $boleto->obtenerFechaYHora() );
		$this->assertEquals( $tarjeta, $boleto->obtenerTarjeta() );
		$this->assertEquals( false, $boleto->esViajePlus() );
		$this->assertEquals( [], $boleto->extras() );

		$tarjetaMedio = new FranquiciaMedio;
		$tarjetaMedio->recargar( $valorsaldo, 0 );

		$boletoMedio = $colectivo->pagarCon( $tarjetaMedio, 0 );

		$this->assertEquals( $colectivo, $boletoMedio->obtenerColectivo() );
		$this->assertEquals( $tarjetaMedio->obtenerSaldo(), $boletoMedio->obtenerSaldo() );
		$this->assertEquals( $PRECIO_MEDIO_BOLETO, $boletoMedio->obtenerValor() );
		$this->assertEquals( 0, $boletoMedio->obtenerFechaYHora() );
		$this->assertEquals( $tarjetaMedio, $boletoMedio->obtenerTarjeta() );
		$this->assertEquals( false, $boletoMedio->esViajePlus() );
		$this->assertEquals( [], $boletoMedio->extras() );

		$tarjetaCompleta = new FranquiciaCompleta;
		$tarjetaCompleta->recargar( $valorsaldo, 0 );

		$boletoCompleto = $colectivo->pagarCon( $tarjetaCompleta, 0 );

		$this->assertEquals( $colectivo, $boletoCompleto->obtenerColectivo() );
		$this->assertEquals( $tarjetaCompleta->obtenerSaldo(), $boletoCompleto->obtenerSaldo() );
		$this->assertEquals( 0., $boletoCompleto->obtenerValor() );
		$this->assertEquals( 0, $boletoCompleto->obtenerFechaYHora() );
		$this->assertEquals( $tarjetaCompleta, $boletoCompleto->obtenerTarjeta() );
		$this->assertEquals( false, $boletoCompleto->esViajePlus() );
		$this->assertEquals( [], $boletoCompleto->extras() );
	}

	public function testPagarsin() {
		global $MAX_PLUS;

		$linea = '107 Fonavi';
		$empresa = 'Rosario Bus';
		$numero = 13;

		$colectivo = new Colectivo( $linea, $empresa, $numero );

		$tarjeta = new Tarjeta;
		for ( $i = 0; $i <= $MAX_PLUS; $i++ ) $tarjeta->generarPago( 0, $colectivo );

		$tarjetaMedio = new FranquiciaMedio;
		for ( $i = 0; $i <= $MAX_PLUS; $i++ ) $tarjetaMedio->generarPago( 0, $colectivo );

		$tarjetaCompleta = new FranquiciaCompleta;


		$this->assertEquals( false, $colectivo->pagarCon( $tarjeta, 0 ) );
		$this->assertEquals( false, $colectivo->pagarCon( $tarjetaMedio, 0 ) );
		$this->assertNotFalse( $colectivo->pagarCon( $tarjetaCompleta, 0 ) );
	}
}
