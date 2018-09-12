<?php

namespace TrabajoTarjeta\Parser;

abstract class Interaccion {
    const INTERACCION_PAGO = 0;
    const INTERACCION_CARGA = 1;

    private $tiempo;

    public function __construct(int $tiempo) {
        $this->tiempo = $tiempo;
    }

    //DE ACA PARA TESTS ------------------------------------

    public function getTiempo(): int {
        return $this->tiempo;
    }
}