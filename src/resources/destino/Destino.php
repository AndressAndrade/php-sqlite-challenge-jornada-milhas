<?php

namespace jornada\mvc\resources\destino;

class Destino
{

	public readonly string $foto;
	public readonly int $id;

	public function __construct(
		string $foto,
		public readonly string $nome,
		public readonly float $preco
	) {
		$this->setFoto($foto);
	}

	private function setFoto(string $foto)
	{
		if (filter_var($foto, FILTER_VALIDATE_URL) === false) {
			throw new \InvalidArgumentException();
		}

		$this->foto = $foto;
	}

	public function setId(int $id): void
	{
		$this->id = $id;
	}
}
