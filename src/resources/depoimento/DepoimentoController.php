<?php

namespace jornada\mvc\resources\depoimento;

class DepoimentoController
{
	public function __construct(private DepoimentoRepository $depoimentoRepository)
	{
	}

	public function list(): void
	{
		header('Content-Type: application/json');
		$depoimentoList =  array_map(function (Depoimento $depoimento): array {
			return [
				'foto' => $depoimento->foto,
				'mensagem' => $depoimento->mensagem,
				'autor' => $depoimento->autor,
			];
		}, $this->depoimentoRepository->all());
		echo json_encode($depoimentoList);
	}
}
