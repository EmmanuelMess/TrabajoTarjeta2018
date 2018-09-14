<?php

namespace TrabajoTarjeta;

class FranquiciaCompleta extends Tarjeta {

    public function getPrecio(int $tiempo): Precio {
        return new Precio(0.0, TipoDeBoleto::Total);
    }
}
