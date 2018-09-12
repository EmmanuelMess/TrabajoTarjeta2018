<?php

use PHPUnit\Framework\TestCase;
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
                }
            }";

        $reciever = new Reciever($json);

        return $reciever->getTarjeta();
    }
}