<?php

namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;

class ColectivoTest extends TestCase {

    public function testLineaEmpresaNumero() {
	$linea="143 Roja";
	$numero=13;
	$empresa="Rosario Bus";
	$colectivo = new Colectivo($linea,$empresa,$numero);
	$this->assertEquals($linea,$colectivo->linea());
	$this->assertEquals($numero,$colectivo->numero());
	$this->assertEquals($empresa,$colectivo->empresa());
    }
}
