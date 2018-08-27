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
        $verificador = $this->saberClase();

        if ($verificador->obtenerTipo() == 2) {
            $this->saldo -= 7.40;
        } else {
            if ($verificador->obtenerTipo() == 3) {
                $this->saldo -= 0;
            } else {
                $this->saldo -= 14.80;
            }
        }
    }

    public function saberClase() {
        return new VerificadordeClases ($this);
    }
}
