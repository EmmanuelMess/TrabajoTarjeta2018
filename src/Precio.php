<?php

namespace TrabajoTarjeta;


class Precio {
    public $PRECIO;
    public $TIPO;

    public function __construct(float $precio, string $tipo) {
        $this->PRECIO = $precio;
        $this->TIPO = $tipo;
    }

}