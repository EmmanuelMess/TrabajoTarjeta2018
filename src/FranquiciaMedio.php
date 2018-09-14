<?php

namespace TrabajoTarjeta;

class FranquiciaMedio extends Tarjeta {

    public function getPrecio(int $tiempo): Precio {
        global $PRECIO_MEDIO_BOLETO;
        return new Precio($PRECIO_MEDIO_BOLETO, TipoDeBoleto::Medio);
    }
}
