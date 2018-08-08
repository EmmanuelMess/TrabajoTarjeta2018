<?php

namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;

class BoletoTest extends TestCase {

    public function testSaldoCero() {
		$val = [10,20,30,50,100,510.15,962.59];
        $valor = 14.80;
        $boleto = new Boleto($valor, NULL, NULL);
        $this->assertEquals($boleto->obtenerValor(), $valor);
    }
}