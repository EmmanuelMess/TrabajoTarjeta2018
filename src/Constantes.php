<?php

namespace TrabajoTarjeta;

use Ds\Set;

global $PRECIO_VIAJE;
$PRECIO_VIAJE = 14.80;
global $VALORES_CARGABLES;
$VALORES_CARGABLES = new Set([10, 20, 30, 50, 100, 510.15, 962.59]);
global $VALORES_ADICIONADOS;
$VALORES_ADICIONADOS = new Set([510.15, 962.59]);//Editar tambien $cargasMap en valorCargado()

function valorCargado($monto) {
    global $VALORES_ADICIONADOS;

    if(!$VALORES_ADICIONADOS->contains($monto)) return $monto;

    static $cargasMap = [51015 => (510.15+81.93), 96259 => (962.59+221.58)];
    static $correccion = 100;

    return $cargasMap[$monto * $correccion];
}