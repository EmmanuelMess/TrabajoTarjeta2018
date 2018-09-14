<?php

namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;

class TarjetaTest extends TestCase {

    /**
     * Comprueba que la tarjeta aumenta su saldo cuando se carga saldo válido.
     */
    public function testCargaSaldo() {
        $val = [0, 10, 20, 30, 50, 100];
        $valf = 510.15;
        $valff = 962.59;
        $tarjeta = new Tarjeta;
        $valorsaldo = 1.;
        $saldo = 0;
        for ($valorsaldo; $valorsaldo < 1000; $valorsaldo++) {
            if (in_array($valorsaldo, $val)) {
                $this->assertTrue($tarjeta->recargar($valorsaldo, 0));
                $saldo += $valorsaldo;
                $this->assertEquals($saldo, $tarjeta->obtenerSaldo());
            }
        }
        $this->assertTrue($tarjeta->recargar($valf, 0));
        $saldo += ($valf + 81.93);
        $this->assertEquals($saldo, $tarjeta->obtenerSaldo());

        $this->assertTrue($tarjeta->recargar($valff, 0));
        $saldo += ($valff + 221.58);
        $this->assertEquals($saldo, $tarjeta->obtenerSaldo());

    }

    /**
     * Comprueba que la tarjeta no puede cargar saldos invalidos.
     */
    public function testCargaSaldoInvalido() {
        $tarjeta = new Tarjeta;
        $valorsaldo = 1.;
        $val = [0, 10, 20, 30, 50, 100];

        for ($valorsaldo; $valorsaldo < 1000; $valorsaldo++) {
            if (!in_array($valorsaldo, $val)) {
                $this->assertFalse($tarjeta->recargar($valorsaldo, 0));
                $this->assertEquals(0, $tarjeta->obtenerSaldo());
            }
        }
    }

    /**
     * Comprueba que la tarjeta puede pagar pluses
     */
    public function testPlus() {
        global $MAX_PLUS;

        $tarjeta = new Tarjeta;
        $tarjetaMedio = new FranquiciaMedio;

        for($i = 0; $i < $MAX_PLUS; $i++) {
            $this->assertFalse($tarjeta->generarPago(0)->FALLO);
            $this->assertFalse($tarjetaMedio->generarPago(0)->FALLO);
        }

        $this->assertTrue($tarjeta->generarPago(0)->FALLO);
        $this->assertTrue($tarjetaMedio->generarPago(0)->FALLO);

        $tarjeta->recargar(100, 0);
        $this->assertFalse($tarjeta->generarPago(0)->FALLO);
        $this->assertEquals(100 - $tarjeta->getPrecio(0)->PRECIO*3, $tarjeta->obtenerSaldo());

        $tarjetaMedio->recargar(100, 0);
        $this->assertFalse($tarjetaMedio->generarPago(0)->FALLO);
        $this->assertEquals(100 - $tarjetaMedio->getPrecio(0)->PRECIO*3, $tarjetaMedio->obtenerSaldo());
    }

    public function testFranquiciaCompleta() {
        global $MAX_PLUS;

        $tarjetaCompleto = new FranquiciaCompleta;

        for($i = 0; $i <= $MAX_PLUS; $i++) {
            $this->assertFalse($tarjetaCompleto->generarPago(0)->FALLO);
        }

        $this->assertFalse($tarjetaCompleto->generarPago(0)->FALLO);
    }
}
