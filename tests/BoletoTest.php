<?php

namespace TrabajoTarjeta;
use PHPUnit\Framework\TestCase;

class BoletoTest extends TestCase {
    /**
     * Testeamos que el valor de los boletos sea el acorde con respecto a la tarjeta que se le pase como parametro
     */
    public function testSaldo() {
        $valor = 14.80;

        $colectivo = new Colectivo(NULL, NULL, NULL);

        $tarjeta = new Tarjeta;
        $tarjeta->recargar(100, 0);
        $tarjetaMedio = new FranquiciaMedio;
        $tarjetaMedio->recargar(100, 0);
        $tarjetaCompleta = new FranquiciaCompleta;
        $tarjetaCompleta->recargar(100, 0);

        $boleto = $colectivo->pagarCon($tarjeta, 0);
        $boletoMedio = $colectivo->pagarCon($tarjetaMedio, 0);
        $boletoCompleto = $colectivo->pagarCon($tarjetaCompleta, 0);

        $this->assertEquals($valor, $boleto->obtenerValor());
        $this->assertEquals($valor / 2, $boletoMedio->obtenerValor());
        $this->assertEquals(0.0, $boletoCompleto->obtenerValor());

    }

}
