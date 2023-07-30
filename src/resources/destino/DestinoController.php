<?php

namespace jornada\mvc\resources\destino;

class DestinoController
{
	public function __construct(private DestinoRepository $destinoRepository)
	{
	}

	public function list()
	{
		header('Content-Type: application/json');
		$destinoContain = filter_input(INPUT_GET, 'nome');
		if ($destinoContain === null) {
			echo json_encode([
				'mensagem' => 'Nenhum destino foi encontrado'
			]);
			return;
		}
		$destinoList =  $this->destinoRepository->findDestinos($destinoContain);
		if (count($destinoList) === 0) {
			echo json_encode([
				'mensagem' => 'Nenhum destino foi encontrado'
			]);
			return;
		}
		$format =  array_map(function (Destino $destino): array {
			return [
				'foto' => $destino->foto,
				'nome' => $destino->nome,
				'preco' => $destino->preco,
			];
		}, $destinoList);
		echo json_encode($format);
	}

	public function get(): void
	{
		header('Content-Type: application/json');
		$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
		$destino = $this->destinoRepository->find($id);
		echo json_encode($destino ? [
			'foto' => $destino->foto,
			'nome' => $destino->nome,
			'preco' => $destino->preco
		] : false);
	}

	public function create(): void
	{
		$request = file_get_contents('php://input');
		$destinoData = json_decode($request, true);
		header('Content-Type: application/json');
		if ($destinoData['foto'] === null || $destinoData['nome'] === null || $destinoData['preco'] === null) {
			echo json_encode(false);
			return;
		}
		$destino = new Destino($destinoData['foto'], $destinoData['nome'], $destinoData['preco']);
		echo json_encode($this->destinoRepository->add($destino));
	}

	public function edit(): void
	{
		$request = file_get_contents('php://input');
		$destinoData = json_decode($request, true);
		$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
		$destino = $this->destinoRepository->find($id);
		if (!$destino) {
			// Destino not found
			echo json_encode(false);
			return;
		}
		header('Content-Type: application/json');
		if (
			($destinoData['foto'] === null || $destinoData['nome'] === null || $destinoData['preco'] === null) ||
			($destinoData['foto'] === $destino->foto && $destinoData['nome'] === $destino->nome && $destinoData['preco'] === $destino->preco)
		) {
			// Nothing to update
			echo json_encode(false);
			return;
		}
		$destino = new Destino(
			$destinoData['foto'] ?? $destino->foto,
			$destinoData['nome'] ?? $destino->nome,
			$destinoData['preco'] ?? $destino->preco
		);
		$destino->setId($id);
		echo json_encode($this->destinoRepository->update($destino));
	}

	public function exclude(): void
	{
		header('Content-Type: application/json');
		$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
		if (!$id) {
			// Destino not found
			echo json_encode(false);
		}
		echo json_encode($this->destinoRepository->remove($id));
	}
}
