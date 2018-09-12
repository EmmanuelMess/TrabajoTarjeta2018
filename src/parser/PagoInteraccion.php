<?php

namespace TrabajoTarjeta\Parser;


class PagoInteraccion extends Interaccion {
    public function __construct(int $tiempo) {
        parent::__construct($tiempo);
    }
}