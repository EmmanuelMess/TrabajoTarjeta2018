<?php

namespace TrabajoTarjeta;

class Tarjeta implements TarjetaInterface {
    protected $saldo = 0;
    protected $boletosPlusUsados = 0;
    protected $ultTiempo = -TiempoAyudante::CINCO_MINUTOS - 1;

    public function recargar($monto, int $tiempo) {
        global $VALORES_CARGABLES;

        if (!$VALORES_CARGABLES->contains((float) $monto)) return false;
        $this->saldo += valorCargado((float) $monto);
        return true;
    }

    public function obtenerSaldo(): float {
        return $this->saldo;
    }

    public function generarPago(int $tiempo): Pago {
        $pago = $this->manejarPago($tiempo);

        if(!$pago->FALLO) {
            $this->alFinalizarPago($tiempo);
        }

        return $pago;
    }

    protected function alFinalizarPago(int $tiempo) {
        $this->ultTiempo = $tiempo;
    }

    private function manejarPago(int $tiempo): Pago {
        global $MAX_PLUS;

        if($this->getPrecio($tiempo)->NO_SE_PUEDE) {
            return Pago::newFallado();
        }

        if($this->getPrecio($tiempo)->PRECIO == 0) {
            return new Pago(false, $this->getPrecio($tiempo),false);
        }

        if($this->obtenerSaldo() - $this->getPrecio($tiempo)->PRECIO < 0) {
            if($this->boletosPlusUsados >= $MAX_PLUS) return Pago::newFallado();

            $this->boletosPlusUsados++;
            return new Pago(false, $this->getPrecio($tiempo), true);
        }

        $extra = [];

        if($this->boletosPlusUsados > 0) {
            $boletosPlusAPagar = ($this->boletosPlusUsados)*$this->getPrecio($tiempo)->PRECIO;

            if($this->saldo - $boletosPlusAPagar + $this->getPrecio($tiempo)->PRECIO < 0) return Pago::newFallado();

            $this->saldo -= $boletosPlusAPagar;
            $this->boletosPlusUsados = 0;

            $extra[] = "Abona viajes plus $".($boletosPlusAPagar);
        }

        $this->saldo -= $this->getPrecio($tiempo)->PRECIO;
        return new Pago(false, $this->getPrecio($tiempo), false, $extra);
    }

    public function getPrecio(int $tiempo): Precio {
        global $PRECIO_VIAJE;
        return new Precio(false, $PRECIO_VIAJE, TipoDeBoleto::Normal);
    }

    protected function getUltTiempo(): int {
        return $this->ultTiempo;
    }
}
