<?php

namespace TrabajoTarjeta;

class VerificadordeClases {

    protected $tipo;

    public function __construct($tarjeta) {

        $this->tipo = 1;

        if ($tarjeta instanceof FranquiciaMedio) {
            $this->tipo = 2;
        }

        if ($tarjeta instanceof FranquiciaCompleta) {
            $this->tipo = 3;
        }
    }

    public function obtenerTipo() {
        return $this->tipo;
    }
}