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
        $valorsaldo = 1;
        $saldo = 0;
        for ($valorsaldo; $valorsaldo < 1000; $valorsaldo++) {
            if (in_array($valorsaldo, $val)) {
                $this->assertTrue($tarjeta->recargar($valorsaldo));
                $saldo += $valorsaldo;
                $this->assertEquals($saldo, $tarjeta->obtenerSaldo());
            }
        }
        $this->assertTrue($tarjeta->recargar($valf));
        $saldo += ($valf + 81.93);
        $this->assertEquals($saldo, $tarjeta->obtenerSaldo());

        $this->assertTrue($tarjeta->recargar($valff));
        $saldo += ($valff + 221.58);
        $this->assertEquals($saldo, $tarjeta->obtenerSaldo());

    }

    /**
     * Comprueba que la tarjeta no puede cargar saldos invalidos.
     */
    public function testCargaSaldoInvalido() {
        $tarjeta = new Tarjeta;
        $valorsaldo = 1;
        $val = [0, 10, 20, 30, 50, 100];

        for ($valorsaldo; $valorsaldo < 1000; $valorsaldo++) {
            if (!in_array($valorsaldo, $val)) {
                $this->assertFalse($tarjeta->recargar($valorsaldo));
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

        for($i = 0; $i <= $MAX_PLUS; $i++) {
            $this->assertTrue($tarjeta->disminuirSaldo());
            $this->assertTrue($tarjetaMedio->disminuirSaldo());
        }

        $this->assertFalse($tarjeta->disminuirSaldo());
        $this->assertFalse($tarjetaMedio->disminuirSaldo());

        $tarjeta->recargar(100);
        $this->assertTrue($tarjeta->disminuirSaldo());
        $this->assertEquals(100 - $tarjeta->getPrecio()*3, $tarjeta->obtenerSaldo());

        $tarjetaMedio->recargar(100);
        $this->assertTrue($tarjetaMedio->disminuirSaldo());
        $this->assertEquals(100 - $tarjetaMedio->getPrecio()*3, $tarjetaMedio->obtenerSaldo());
    }

    public function testFranquiciaCompleta() {
        global $MAX_PLUS;

        $tarjetaCompleto = new FranquiciaCompleta;

        for($i = 0; $i <= $MAX_PLUS; $i++) {
            $this->assertTrue($tarjetaCompleto->disminuirSaldo());
        }

        $this->assertTrue($tarjetaCompleto->disminuirSaldo());
    }
}
