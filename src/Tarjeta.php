<?php

namespace TrabajoTarjeta;

class Tarjeta implements TarjetaInterface {
    protected $saldo;

    public function recargar($monto) {
        global $VALORES_CARGABLES;

        if (!$VALORES_CARGABLES->contains($monto)) return false;
        $this->saldo += valorCargado($monto);
        return true;
    }

    /**
     * Devuelve el saldo que le queda a la tarjeta.
     *
     * @return float
     */
    public function obtenerSaldo() {
        return $this->saldo;
    }

    public function disminuirSaldo() {
        if($this->obtenerSaldo() - $this->getPrecio() < 0) return false;
        $this->saldo -= $this->getPrecio();
        return true;
    }

    public function getPrecio() {
        global $PRECIO_VIAJE;
        return $PRECIO_VIAJE;
    }
}
