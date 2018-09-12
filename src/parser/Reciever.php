<?php

namespace TrabajoTarjeta\Parser;

use InvalidArgumentException;
use \TrabajoTarjeta\Tarjeta;
use \TrabajoTarjeta\FranquiciaMedio;
use \TrabajoTarjeta\FranquiciaCompleta;

class Reciever {

    const TARJETA_NORMAL = 0;
    const TARJETA_MEDIO = 1;
    const TARJETA_COMPLETO = 2;

    private $tarjeta;


    public function __construct(string $json) {
        $decoded = json_decode($json);
        if($decoded === null) throw new InvalidArgumentException("Json invalido!");

        $this->tarjeta = $this->createTarjeta($decoded->TarjetaInicial->Tipo);
    }

    private function createTarjeta(int $tipo): Tarjeta {
        switch ($tipo) {
            case Reciever::TARJETA_NORMAL:
                return new Tarjeta;
            case Reciever::TARJETA_MEDIO:
                return new FranquiciaMedio;
            case Reciever::TARJETA_COMPLETO:
                return new FranquiciaCompleta;
            default:
                throw new InvalidArgumentException($tipo." es invalido!");
        }
    }


    /*
     * -------------------------------------------------------------------
     * DE ACA PARA TESTS
     * NO USAR
     */

    public function getTarjeta(): Tarjeta {
        return $this->tarjeta;
    }
}