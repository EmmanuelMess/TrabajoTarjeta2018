<?php

namespace TrabajoTarjeta;
use PHPUnit\Framework\TestCase;

class BoletoTest extends TestCase {
	/**
	 * Testeamos que el valor de los boletos sea el acorde con respecto a la tarjeta que se le pase como parametro
	 */
	public function testSaldo() {
		$valor = 14.80;

		$colectivo = new Colectivo( null, null, null );

		$tarjeta = new Tarjeta;
		$tarjeta->recargar( 100, 0 );
		$tarjetaMedio = new FranquiciaMedio;
		$tarjetaMedio->recargar( 100, 0 );
		$tarjetaCompleta = new FranquiciaCompleta;
		$tarjetaCompleta->recargar( 100, 0 );

		$boleto = $colectivo->pagarCon( $tarjeta, 0 );
		$boletoMedio = $colectivo->pagarCon( $tarjetaMedio, 0 );
		$boletoCompleto = $colectivo->pagarCon( $tarjetaCompleta, 0 );

		$this->assertEquals( $valor, $boleto->obtenerValor() );
		$this->assertEquals( $valor / 2, $boletoMedio->obtenerValor() );
		$this->assertEquals( 0.0, $boletoCompleto->obtenerValor() );
	}

	public function testTransbordo() {
		//________________________________________________________________________
		$tarjeta = new Tarjeta;
		$tarjeta->recargar( 100, 0 );
		$tiempo = new TiempoAyudante();
		$t = time();
		echo $t;
		echo date( "((H:i:s))\n", $t );
		$t += 90 * 60;
		echo date( "((H:i:s))\n", $t );

		echo($tiempo->saber_dia( $t ));
		echo($tiempo->saber_hora( $t ));
		echo($tiempo->saber_dia_ymd( $t ));

		$t = $tiempo->saber_hora( $t );
		$t2 = "00:00:00";
		if ( "22:00:00" > $t ) {
			echo "TRUE";
		} else {
			echo "\nFALSE";
		}

		$tiempofijo = 1537826066;
		echo date( "\n((Y-m-d) (H:i:s))", $tiempofijo ); //(2018-09-24) (21:54:26) LUNES TIEMPO FIJO PARA USAR EN LOS TEST

		//________________________________________________________________________
		//probamos lo ciclos del transbordo 1 si otro no
		$this->assertEquals( false, $tarjeta->estransbordo( $tiempofijo, '143', 'N' ) );
		$this->assertEquals( true, $tarjeta->estransbordo( $tiempofijo, '142', 'N' ) );
		$this->assertEquals( false, $tarjeta->estransbordo( $tiempofijo, '143', 'R' ) );
		$this->assertEquals( true, $tarjeta->estransbordo( $tiempofijo, '140', 'N' ) );
		//________________________________________________________________________
		//________________________________________________________________________
		//TEST NOCHE
		$tiempofijo += 3600;// (2018-09-24) (22:54:26) LUNES TIEMPO FIJO PARA USAR EN LOS TEST
		echo date( "\n((Y-m-d) (H:i:s))", $tiempofijo );
		$this->assertEquals( false, $tarjeta->estransbordo( $tiempofijo, '133', 'N' ) );
		$tiempofijo += 5400;// (2018-09-25) (00:24:26) MARTES TIEMPO FIJO PARA USAR EN LOS TEST
		echo date( "\n((Y-m-d) (H:i:s))", $tiempofijo );
		$this->assertEquals( true, $tarjeta->estransbordo( $tiempofijo, '133', 'V' ) );
		$this->assertEquals( false, $tarjeta->estransbordo( $tiempofijo, '133', 'V' ) );
		$tiempofijo += 1; // (2018-09-25) (00:24:27) MARTES TIEMPO FIJO PARA USAR EN LOS TEST NOS PASAMOS DE LOS 90 MIN DE LA NOCHE
		$this->assertEquals( false, $tarjeta->estransbordo( $tiempofijo, '133', 'R' ) );
		//________________________________________________________________________
		//TEST DIA cuando tiene dos false seguidos no tolera pero se recupera
		$tiempofijo += 21600; // (2018-09-25) (06:24:27) MARTES TIEMPO FIJO PARA USAR EN LOS TEST NOS PASAMOS DE LOS 60 MIN DEL DIA
		$this->assertEquals( false, $tarjeta->estransbordo( $tiempofijo, '141', 'N' ) );
		echo date( "\n((Y-m-d) (H:i:s))", $tiempofijo );
		$tiempofijo += 3600; // (2018-09-25) (07:24:27) MARTES TIEMPO FIJO PARA USAR EN LOS TEST NOS PASAMOS DE LOS 60 MIN DEL DIA
		echo date( "\n((Y-m-d) (H:i:s))", $tiempofijo );
		$this->assertEquals( false, $tarjeta->estransbordo( $tiempofijo, '141', 'R' ) );
		$tiempofijo += 3600;// (2018-09-25) (08:24:28) MARTES TIEMPO FIJO PARA USAR EN LOS TEST NOS PASAMOS DE LOS 60 MIN DEL DIA
		$this->assertEquals( true, $tarjeta->estransbordo( $tiempofijo, '143', 'N' ) );
		$tiempofijo += 3601;// (2018-09-25) (09:24:29) MARTES TIEMPO FIJO PARA USAR EN LOS TEST NOS PASAMOS DE LOS 60 MIN DEL DIA
		$this->assertEquals( false, $tarjeta->estransbordo( $tiempofijo, '143', 'R' ) );
		$tiempofijo += 3600;// (2018-09-25) (10:24:29) MARTES TIEMPO FIJO PARA USAR EN LOS TEST NOS PASAMOS DE LOS 60 MIN DEL DIA
		$this->assertEquals( true, $tarjeta->estransbordo( $tiempofijo, '101', 'N' ) );
		//________________________________________________________________________
		//TEST SABADO cuando tiene dos false seguidos no tolera pero se recupera
		$tiempofijo += 345600;// (2018-09-29) (10:24:29) SABADO TIEMPO FIJO PARA USAR EN LOS TEST NOS PASAMOS DE LOS 60 MIN DEL DIA
		$this->assertEquals( false, $tarjeta->estransbordo( $tiempofijo, '103', 'N' ) );
		$tiempofijo += 3600;// (2018-09-29) (11:24:29) SABADO TIEMPO FIJO PARA USAR EN LOS TEST NOS PASAMOS DE LOS 60 MIN DEL DIA
		$this->assertEquals( true, $tarjeta->estransbordo( $tiempofijo, '143', 'N' ) );
		$tiempofijo += 3601;// (2018-09-29) (12:24:30) SABADO TIEMPO FIJO PARA USAR EN LOS TEST NOS PASAMOS DE LOS 60 MIN DEL DIA
		$this->assertEquals( false, $tarjeta->estransbordo( $tiempofijo, '144', 'N' ) );
		$tiempofijo += 7200;// (2018-09-29) (14:24:30) SABADO TIEMPO FIJO PARA USAR EN LOS TEST NOS PASAMOS DE LOS 60 MIN DEL DIA
		$this->assertEquals( false, $tarjeta->estransbordo( $tiempofijo, '145', 'N' ) );
		$tiempofijo += 3600;// (2018-09-29) (15:24:30) SABADO TIEMPO FIJO PARA USAR EN LOS TEST NOS PASAMOS DE LOS 90 MIN DEL DIA
		$this->assertEquals( false, $tarjeta->estransbordo( $tiempofijo, '143', 'N' ) );
		$tiempofijo += 3600;// (2018-09-29) (16:24:30) SABADO TIEMPO FIJO PARA USAR EN LOS TEST NOS PASAMOS DE LOS 90 MIN DEL DIA
		$this->assertEquals( true, $tarjeta->estransbordo( $tiempofijo, '143', 'R' ) );
		$tiempofijo += 5400;// (2018-09-29) (17:54:30) SABADO TIEMPO FIJO PARA USAR EN LOS TEST NOS PASAMOS DE LOS 90 MIN DEL DIA
		$this->assertEquals( false, $tarjeta->estransbordo( $tiempofijo, '120', 'N' ) );
		$tiempofijo += 5400;// (2018-09-29) (19:24:30) SABADO TIEMPO FIJO PARA USAR EN LOS TEST NOS PASAMOS DE LOS 90 MIN DEL DIA
		$this->assertEquals( true, $tarjeta->estransbordo( $tiempofijo, '101', 'N' ) );
		//________________________________________________________________________
		//TEST DOMINGO y FERIADOS
		$tiempofijo += 39600;// (2018-09-30) (06:24:30) DOMINGO TIEMPO FIJO PARA USAR EN LOS TEST NOS PASAMOS DE LOS 90 MIN DEL DIA
		$this->assertEquals( false, $tarjeta->estransbordo( $tiempofijo, '143', 'N' ) );
		//echo date("\n((Y-m-d) (H:i:s))", $tiempofijo);
		//echo($tiempo->saber_dia($tiempofijo));
		$tiempofijo += 5400;// (2018-09-30) (07:54:30) DOMINGO TIEMPO FIJO PARA USAR EN LOS TEST NO NOS PASAMOS DE LOS 90 MIN DEL DIA
		$this->assertEquals( true, $tarjeta->estransbordo( $tiempofijo, '143', 'R' ) );
		$this->assertEquals( false, $tarjeta->estransbordo( $tiempofijo, '143', 'R' ) );
		$tiempofijo += 1;// (2018-09-30) (07:54:31) DOMINGO TIEMPO FIJO PARA USAR EN LOS TEST NOS PASAMOS DE LOS 90 MIN DEL DIA
		$this->assertEquals( false, $tarjeta->estransbordo( $tiempofijo, '146', 'N' ) );
		$tiempofijo += 7200;// (2018-09-30) (09:54:31) DOMINGO TIEMPO FIJO PARA USAR EN LOS TEST NOS PASAMOS DE LOS 90 MIN DEL DIA
		$this->assertEquals( false, $tarjeta->estransbordo( $tiempofijo, '146', 'R' ) );
		$this->assertEquals( false, $tarjeta->estransbordo( $tiempofijo, '146', 'R' ) );
		//echo date("m-d", $tiempofijo);
		//________________________________________________________________________
	}

}
