<?php

namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;

class ColectivoTest extends TestCase {

    public function testLinea() {
	$linea="143 Roja";
	$numero=13;
	$empresa="Rosario Bus";
	$colectivo = new Colectivo($linea,$empresa,$numero);
	$this->assertEquals($linea,$colectivo->linea());
    }
}
