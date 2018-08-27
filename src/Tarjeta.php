<?php

namespace TrabajoTarjeta;

class Tarjeta implements TarjetaInterface {
    protected $saldo;
    protected $boletosPlusUsados;

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
        global $MAX_PLUS;
        if($this->getPrecio() == 0) return true;

        if($this->obtenerSaldo() - $this->getPrecio() < 0) {
            if($this->boletosPlusUsados > $MAX_PLUS) return false;

            $this->boletosPlusUsados++;
            return true;
        }

        if($this->boletosPlusUsados > 0) {
            if($this->saldo - 3*$this->getPrecio() < 0) return false;

            $this->saldo -= 2*$this->getPrecio();
            $this->boletosPlusUsados = 0;
        }

        $this->saldo -= $this->getPrecio();
        return true;
    }

    public function getPrecio() {
        global $PRECIO_VIAJE;
        return $PRECIO_VIAJE;
    }
}
