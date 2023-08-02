<?php

declare(strict_types=1);

namespace jornada\mvc\resources\destino;

use PDO;

class DestinoRepository
{
	public function __construct(private PDO $pdo)
	{
	}

	public function add(Destino $destino): bool
	{
		$sql = 'INSERT INTO destinos (foto, nome, preco) VALUES (?, ?, ?)';
		$statement = $this->pdo->prepare($sql);
		$statement->bindValue(1, $destino->foto);
		$statement->bindValue(2, $destino->nome);
		$statement->bindValue(3, $destino->preco);

		$result = $statement->execute();
		$id = $this->pdo->lastInsertId();

		$destino->setId(intval($id));

		return $result;
	}

	public function remove(int $id): bool
	{
		$sql = 'DELETE FROM destinos WHERE id = ?';
		$statement = $this->pdo->prepare($sql);
		$statement->bindValue(1, $id);

		return $statement->execute();
	}

	public function update(Destino $destino): bool
	{
		$sql = "UPDATE destinos SET
                  foto = :foto,
                  nome = :nome,
				  preco = :preco
              WHERE id = :id;";
		$statement = $this->pdo->prepare($sql);

		$statement->bindValue(':foto', $destino->foto);
		$statement->bindValue(':nome', $destino->nome);
		$statement->bindValue(':preco', $destino->preco);
		$statement->bindValue(':id', $destino->id, PDO::PARAM_INT);

		return $statement->execute();
	}

	/**
	 * @return Destino[]
	 */
	public function listDestinos($name = false): array
	{
		if (!$name) {
			$destinoList = $this->pdo
				->query("SELECT * from destinos;")
				->fetchAll(PDO::FETCH_ASSOC);
		} else {
			$destinoList = $this->pdo
				->query("SELECT * from destinos WHERE nome LIKE '%$name%';")
				->fetchAll(PDO::FETCH_ASSOC);
		}
		if (count($destinoList) === 0) {
			return [];
		}
		return array_map(
			$this->hydrateDestino(...),
			$destinoList
		);
	}

	public function find(int $id)
	{
		$statement = $this->pdo->prepare('SELECT * FROM destinos WHERE id = ?;');
		$statement->bindValue(1, $id, PDO::PARAM_INT);
		$statement->execute();
		$destino = $statement->fetch(PDO::FETCH_ASSOC);

		if (!$destino) {
			return $destino;
		}

		return $this->hydrateDestino($destino);
	}

	private function hydrateDestino(array $destino): Destino
	{
		$destinoHidratado = new Destino($destino['foto'], $destino['nome'], $destino['preco']);
		$destinoHidratado->setId($destino['id']);

		return $destinoHidratado;
	}
}
