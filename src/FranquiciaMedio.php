<?php

namespace TrabajoTarjeta;

class FranquiciaMedio extends Tarjeta {

    private $pagosHoy = 0;

    public function getPrecio(int $tiempo): Precio {
        global $PRECIO_VIAJE;
        global $PRECIO_MEDIO_BOLETO;

        if($this->pagosHoy >= 2 && TiempoAyudante::pertenecenAlMismoDia($this->getUltTiempo(), $tiempo)) {
            return new Precio(false, $PRECIO_VIAJE, TipoDeBoleto::Normal);
        }

        $noSePuede = $tiempo - $this->getUltTiempo() < TiempoAyudante::CINCO_MINUTOS;
        return new Precio($noSePuede, $PRECIO_MEDIO_BOLETO, TipoDeBoleto::Medio);
    }

    protected function alFinalizarPago(int $tiempo) {
        if(!TiempoAyudante::pertenecenAlMismoDia($this->getUltTiempo(), $tiempo)) {
            $this->pagosHoy = 1;
        } else {
            $this->pagosHoy++;
        }

        parent::alFinalizarPago($tiempo);
    }
}
