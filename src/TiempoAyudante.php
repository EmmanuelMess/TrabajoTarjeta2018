<?php

namespace TrabajoTarjeta;

class TiempoAyudante {
	const CINCO_MINUTOS = 5 * 60;
	const UN_DIA = 24 * 60 * 60;

	public function saber_dia( $nombredia ) {
		$nombredia = date( "Y-m-d", $nombredia );
		$dias = array(
			'Domingo',
			'Lunes',
			'Martes',
			'Miercoles',
			'Jueves',
			'Viernes',
			'Sabado'
		);
		if ( date( 'N', strtotime( $nombredia ) ) == 7 ) {
			$fecha = $dias[0];
		} else {
			$fecha = $dias[ date( 'N', strtotime( $nombredia ) ) ];
		}


		return $fecha;
	}

	public function saber_hora( $hora ) {
		$horadia = date( "H:i:s", $hora );
		return $horadia;
	}

	public function saber_dia_ymd( $nombredia ) {
		$fecha = date( "Y-m-d", $nombredia );
		return $fecha;
	}

	public function saber_dia_md( $nombredia ) {
		$fecha = date( "m-d", $nombredia );
		return $fecha;
	}

	// ejecutamos la funci�n pas�ndole la fecha que queremos
	//saber_dia('2015-03-13');


	public static function pertenecenAlMismoDia( int $a, int $b ) {
		return date( 'Y-M-d', $a ) === date( 'Y-M-d', $b );
	}
}