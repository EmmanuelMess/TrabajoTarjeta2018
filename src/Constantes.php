<?php

namespace TrabajoTarjeta;

use Ds\Set;

global $DIASFERIADOS;
$DIASFERIADOS = array(
	'01-01',
	'02-12',
	'02-13',
	'03-24',
	'03-30',
	'03-29',
	'03-31',
	'04-02',
	'05-01',
	'05-25',
	'06-17',
	'06-20',
	'07-09',
	'08-20',
	'10-12',
	'11-20',
	'12-08',
	'12-25',
	'12-31'
);
global $MAX_PLUS;
$MAX_PLUS = 2;
global $PRECIO_VIAJE;
$PRECIO_VIAJE = 14.80;
global $PRECIO_MEDIO_BOLETO;
$PRECIO_MEDIO_BOLETO = $PRECIO_VIAJE/2;
global $PRECIO_RELATIVO_TRANSBORDO;
$PRECIO_RELATIVO_TRANSBORDO = 0.33;
global $VALORES_CARGABLES;
$VALORES_CARGABLES = new Set( [
	10.,
	20.,
	30.,
	50.,
	100.,
	510.15,
	962.59
] );
global $VALORES_ADICIONADOS;
$VALORES_ADICIONADOS = new Set( [
	510.15,
	962.59
] );//Editar tambien $cargasMap en valorCargado()

function valorCargado($monto) {
	global $VALORES_ADICIONADOS;

	if ( !$VALORES_ADICIONADOS->contains( $monto ) ) return $monto;

	static $cargasMap = [
		51015 => (510.15 + 81.93),
		96259 => (962.59 + 221.58)
	];
	static $correccion = 100;

	return $cargasMap[ $monto * $correccion ];
}
