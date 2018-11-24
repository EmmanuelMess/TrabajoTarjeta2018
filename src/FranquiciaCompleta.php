<?php

namespace TrabajoTarjeta;

class FranquiciaCompleta extends Tarjeta {

	public function getPrecio( int $tiempo, ColectivoInterface $colectivo ): Precio {
		return new Precio( false, 0.0, TipoDeBoleto::Total );
	}
}
