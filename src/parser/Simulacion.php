<?php

namespace TrabajoTarjeta\Parser;

use TrabajoTarjeta\Tarjeta;

function correrSimulacion(string $json): string {
	$estados = [];
	$reciever = new Parser( $json );

	$tarjeta = $reciever->getTarjeta();
	$interacciones = $reciever->getInteracciones();

	foreach ( $interacciones as $interaccion ) {
		$estados[] = interactuarYGenerarEstado( $interaccion, $tarjeta );
	}

	$estadosJson = [];

	foreach ( $estados as $estado ) {
		$estadosJson[] = $estado->comoArray();
	}

	return json_encode( $estadosJson );
}

function interactuarYGenerarEstado(Interaccion $interaccion, Tarjeta $tarjeta): Estado {
	$tiempo = $interaccion->getTiempo();
	$saldoInicial = $tarjeta->obtenerSaldo();
	$msg = "";

	$interaccion->correrInteraccion( $tarjeta );

	return new Estado( $tiempo, $tarjeta->obtenerSaldo(), $tarjeta->obtenerSaldo() - $saldoInicial, $msg );
}