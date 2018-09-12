<?php

namespace TrabajoTarjeta\Parser;

function correrSimulacion(string $json): Tabla {
    $estados = [];
    $reciever = new Parser($json);

    $tarjeta = $reciever->getTarjeta();
    $interacciones = $reciever->getInteracciones();

    foreach($interacciones as $interaccion) {
        $interaccion->correrInteraccion($tarjeta);
        $estados[] = new Estado($tarjeta);
    }

    return new Tabla($estados);
}