<?php

namespace TrabajoTarjeta;

class FranquiciaMedio extends Tarjeta {

    public function getPrecio() {
        global $PRECIO_MEDIO_BOLETO;
        return $PRECIO_MEDIO_BOLETO;
    }
}
