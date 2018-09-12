<?php

use PHPUnit\Framework\TestCase;
use TrabajoTarjeta\Parser\CargaInteraccion;
use TrabajoTarjeta\Parser\Interaccion;
use TrabajoTarjeta\Parser\PagoInteraccion;
use TrabajoTarjeta\Parser\Reciever;
use TrabajoTarjeta\Tarjeta;

class RecieverTest extends TestCase {
    public function testTarjeta() {
        $this->assertInstanceOf(Tarjeta::class, $this->crearTarjeta(Reciever::TARJETA_NORMAL));
        $this->assertInstanceOf(Tarjeta::class, $this->crearTarjeta(Reciever::TARJETA_MEDIO));
        $this->assertInstanceOf(Tarjeta::class, $this->crearTarjeta(Reciever::TARJETA_COMPLETO));
    }

    private function crearTarjeta(int $tipo): Tarjeta {
        $json =
            "{
                \"TarjetaInicial\": {
                    \"Tipo\": ".$tipo."
                },
                \"Interacciones\": []
            }";

        $reciever = new Reciever($json);

        return $reciever->getTarjeta();
    }

    const CARGA_NULA = -9999999999;

    public function testInteraccionPago() {
        $tiempo = 5555555;
        $interaccion = $this->crearInteraccion(Interaccion::INTERACCION_PAGO, RecieverTest::CARGA_NULA, $tiempo);
        $this->assertInstanceOf(PagoInteraccion::class, $interaccion);
        $this->assertEquals($tiempo, $interaccion->getTiempo());
    }

    public function testInteraccionRecarga() {
        $saldo = 10;
        $tiempo = 5555555;
        $interaccion = $this->crearInteraccion(Interaccion::INTERACCION_PAGO, $saldo, $tiempo);
        $this->assertInstanceOf(CargaInteraccion::class, $interaccion);
        $this->assertEquals($saldo, $interaccion->getCarga());
        $this->assertEquals($tiempo, $interaccion->getTiempo());
    }

    private function crearInteraccion(int $tipo, float $carga, int $tiempo): Interaccion {
        $json =
            "{
                \"TarjetaInicial\": {
                    \"Tipo\": ".Reciever::TARJETA_NORMAL."
                }, 
                \"Interacciones\": [
                    {
                        \"Tipo\": ".$tipo.",";

        if($carga != RecieverTest::CARGA_NULA) {
            $json = $json.
                        "\"Carga\": ".$carga.",";
        }

        $json = $json.
             "          \"Tiempo\": ".$tiempo."
                    }
                ]
            }";

        $reciever = new Reciever($json);

        return $reciever->getInteracciones()[0];
    }
}