<?php

namespace TrabajoTarjeta;
use PHPUnit\Framework\TestCase;

class BoletoTest extends TestCase {
    /**
     * Testeamos que el valor de los boletos sea el acorde con respecto a la tarjeta que se le pase como parametro
     */
    public function testSaldo() {
        $valor = 14.80;

		$tarjeta = new Tarjeta;
		$tarjetaMedio = new FranquiciaMedio;
		$tarjetaCompleta = new FranquiciaCompleta;

        $boleto = new Boleto($valor, NULL, $tarjeta);
		$boletoMedio = new Boleto($valor, NULL, $tarjetaMedio);
		$boletoCompleto = new Boleto($valor, NULL, $tarjetaCompleta);

        $this->assertEquals($valor,$boleto->obtenerValor());
		$this->assertEquals($valor/2,$boletoMedio->obtenerValor());
		$this->assertEquals(0.0,$boletoCompleto->obtenerValor());

    }

	 /**
     * Testeamos que los boletos con diferentes valores correspondan a sus respectivas tarjetas
     */
	    public function testTarjeta() {
        $valor = 14.80;

		$tarjeta = new Tarjeta;
		$tarjetaMedio = new FranquiciaMedio;
		$tarjetaCompleta = new FranquiciaCompleta;

        $boleto = new Boleto($valor, NULL, $tarjeta);
		$boletoMedio = new Boleto($valor, NULL, $tarjetaMedio);
		$boletoCompleto = new Boleto($valor, NULL, $tarjetaCompleta);

        $this->assertEquals($tarjeta,$boleto->obtenerTarjeta());
		$this->assertEquals($tarjetaMedio,$boletoMedio->obtenerTarjeta());
		$this->assertEquals($tarjetaCompleta,$boletoCompleto->obtenerTarjeta());
    }
}
