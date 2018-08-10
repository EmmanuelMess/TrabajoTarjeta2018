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
                $this->assertEquals($tarjeta->obtenerSaldo(), $saldo);
            }
        }
        $this->assertTrue($tarjeta->recargar($valf));
        $saldo += ($valf + 81.93);
        $this->assertEquals($tarjeta->obtenerSaldo(), $saldo);

        $this->assertTrue($tarjeta->recargar($valff));
        $saldo += ($valff + 221.58);
        $this->assertEquals($tarjeta->obtenerSaldo(), $saldo);

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
                $this->assertEquals($tarjeta->obtenerSaldo(), 0);
            }
        }

    }
}

