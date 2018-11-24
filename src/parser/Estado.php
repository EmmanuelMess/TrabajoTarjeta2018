<?php

namespace TrabajoTarjeta\Parser;

use TrabajoTarjeta\Tarjeta;

class Estado {
	private $tiempo;
	private $saldo;
	private $diferencia;
	private $msg;

	public function __construct( int $tiempo, float $saldo, float $diferencia, string $msg ) {
		$this->tiempo = $tiempo;
		$this->saldo = $saldo;
		$this->diferencia = $diferencia;
		$this->msg = $msg;
	}

	public function getTiempo(): int {
		return $this->tiempo;
	}

	public function getSaldo(): float {
		return $this->saldo;
	}

	public function getDiferencia(): float {
		return $this->diferencia;
	}

	public function getMsg(): string {
		return $this->msg;
	}

	public function comoArray(): array {
		return array(
			"Tiempo"     => $this->tiempo,
			"Saldo"      => $this->saldo,
			"Diferencia" => $this->diferencia,
			"Mensaje"    => $this->msg
		);
	}
}