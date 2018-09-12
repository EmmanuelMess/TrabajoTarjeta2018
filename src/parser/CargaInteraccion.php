<?php

namespace TrabajoTarjeta\Parser;


class CargaInteraccion extends Interaccion {

    private $carga;

    public function __construct(float $carga, int $tiempo) {
        parent::__construct($tiempo);

        $this->carga = $carga;
    }

    //DE ACA PARA TESTS -----------------------------------------------

    public function getCarga() {
        return $this->carga;
    }
}