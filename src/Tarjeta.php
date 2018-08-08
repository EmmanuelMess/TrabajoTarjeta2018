<?php

namespace TrabajoTarjeta;

class Tarjeta implements TarjetaInterface {
    protected $saldo;

    public function recargar($monto) {
        global $VALORES_CARGABLES;

        if(!$VALORES_CARGABLES->contains($monto)) return false;

		if($monto==510.15){$this->saldo+=(510.15+81.93);return true;}
		if($monto==962.59){$this->saldo+=(962.59+221.58);return true;}
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

}
