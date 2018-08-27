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

        $colectivo = new Colectivo($linea, $empresa, $numero);

        $this->assertEquals($linea, $colectivo->linea());
        $this->assertEquals($numero, $colectivo->numero());
        $this->assertEquals($empresa, $colectivo->empresa());
    }

    /**
     * Comprueba que a partir de 3 tarjetas distintas ya cargadas con un saldo de $50 y 3 boletos que ya fueron testeados es sus campos, se convalide que las funciones de colectivo devuelva un boleto correcto dependiendo
     *    de la tarjeta y ademas disminuya su saldo
     */

    public function testPagarcon() {
        $valor = 14.80;
        $valorsaldo = 50;

        $linea = '107 Fonavi';
        $empresa = 'Rosario Bus';
        $numero = 13;

        $tarjeta = new Tarjeta;
        $tarjeta->recargar($valorsaldo);
        $tarjetaMedio = new FranquiciaMedio;
        $tarjetaMedio->recargar($valorsaldo);
        $tarjetaCompleta = new FranquiciaCompleta;
        $tarjetaCompleta->recargar($valorsaldo);

        $boleto = new Boleto($valor, $linea, $tarjeta);
        $boletoMedio = new Boleto($valor/2, $linea, $tarjetaMedio);
        $boletoCompleto = new Boleto(0.0, $linea, $tarjetaCompleta);

        $colectivo = new Colectivo($linea, $empresa, $numero);

        $this->assertEquals($boleto, $colectivo->pagarCon($tarjeta));
        $this->assertEquals($boletoMedio, $colectivo->pagarCon($tarjetaMedio));
        $this->assertEquals($boletoCompleto, $colectivo->pagarCon($tarjetaCompleta));

        $this->assertEquals($valorsaldo - $boleto->obtenerValor(), $tarjeta->obtenerSaldo());
        $this->assertEquals($valorsaldo - $boletoMedio->obtenerValor(), $tarjetaMedio->obtenerSaldo());
        $this->assertEquals($valorsaldo - $boletoCompleto->obtenerValor(), $tarjetaCompleta->obtenerSaldo());
    }

    public function testPagarsin() {
        global $MAX_PLUS;

        $linea = '107 Fonavi';
        $empresa = 'Rosario Bus';
        $numero = 13;

        $tarjeta = new Tarjeta;
        for($i = 0; $i <= $MAX_PLUS; $i++) $tarjeta->disminuirSaldo();

        $tarjetaMedio = new FranquiciaMedio;
        for($i = 0; $i <= $MAX_PLUS; $i++) $tarjetaMedio->disminuirSaldo();

        $tarjetaCompleta = new FranquiciaCompleta;

        $colectivo = new Colectivo($linea, $empresa, $numero);

        $boletoCompleto = new Boleto(0.0, $linea, $tarjetaCompleta);

        $this->assertEquals(false, $colectivo->pagarCon($tarjeta));
        $this->assertEquals(false, $colectivo->pagarCon($tarjetaMedio));
        $this->assertEquals($boletoCompleto, $colectivo->pagarCon($tarjetaCompleta));
    }
}
