<?php

namespace jornada\mvc\resources\depoimento;

class DepoimentoController
{
	public function __construct(private DepoimentoRepository $depoimentoRepository)
	{
	}

	public function home(): void
	{
		header('Content-Type: application/json');
		$depoimentoList =  array_map(function (Depoimento $depoimento): array {
			return [
				'foto' => $depoimento->foto,
				'mensagem' => $depoimento->mensagem,
				'autor' => $depoimento->autor,
			];
		}, $this->depoimentoRepository->last3());
		echo json_encode($depoimentoList);
	}

	public function get(): void
	{
		header('Content-Type: application/json');
		$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
		$depoimento = $this->depoimentoRepository->find($id);
		echo json_encode($depoimento ? [
			'foto' => $depoimento->foto,
			'mensagem' => $depoimento->mensagem,
			'autor' => $depoimento->autor
		] : false);
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

	public function create(): void
	{
		$request = file_get_contents('php://input');
		$depoimentoData = json_decode($request, true);
		header('Content-Type: application/json');
		if ($depoimentoData['foto'] === null || $depoimentoData['mensagem'] === null || $depoimentoData['autor'] === null) {
			echo json_encode(false);
			return;
		}
		$depoimento = new Depoimento($depoimentoData['foto'], $depoimentoData['mensagem'], $depoimentoData['autor']);
		echo json_encode($this->depoimentoRepository->add($depoimento));
	}

	public function edit(): void
	{
		$request = file_get_contents('php://input');
		$depoimentoData = json_decode($request, true);
		$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
		$depoimento = $this->depoimentoRepository->find($id);
		if (!$depoimento) {
			// Depoimento not found
			echo json_encode(false);
			return;
		}
		header('Content-Type: application/json');
		if (
			($depoimentoData['foto'] === null || $depoimentoData['mensagem'] === null || $depoimentoData['autor'] === null) ||
			($depoimentoData['foto'] === $depoimento->foto && $depoimentoData['mensagem'] === $depoimento->mensagem && $depoimentoData['autor'] === $depoimento->autor)
		) {
			// Nothing to update
			echo json_encode(false);
			return;
		}
		$depoimento = new Depoimento(
			$depoimentoData['foto'] ?? $depoimento->foto,
			$depoimentoData['mensagem'] ?? $depoimento->mensagem,
			$depoimentoData['autor'] ?? $depoimento->autor
		);
		$depoimento->setId($id);
		echo json_encode($this->depoimentoRepository->update($depoimento));
	}

	public function exclude(): void
	{
		header('Content-Type: application/json');
		$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
		if (!$id) {
			// Depoimento not found
			echo json_encode(false);
		}
		echo json_encode($this->depoimentoRepository->remove($id));
	}
}
