<?php

namespace TrabajoTarjeta;

class TiempoAyudante {
    const CINCO_MINUTOS = 5*60;
    const UN_DIA = 24*60*60;

    public static function pertenecenAlMismoDia(int $a, int $b) {
        return date('Y-M-d', $a) === date('Y-M-d', $b);
    }
}