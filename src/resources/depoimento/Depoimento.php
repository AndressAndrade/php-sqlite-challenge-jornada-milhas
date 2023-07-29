<?php

namespace jornada\mvc\resources\depoimento;

class Depoimento
{

	public readonly string $foto;
	public readonly int $id;

	public function __construct(
		string $foto,
		public readonly string $mensagem,
		public readonly string $autor
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
