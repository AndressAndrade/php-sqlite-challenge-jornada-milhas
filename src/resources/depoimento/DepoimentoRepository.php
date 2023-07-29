<?php

declare(strict_types=1);

namespace jornada\mvc\resources\depoimento;

use PDO;

class DepoimentoRepository
{
	public function __construct(private PDO $pdo)
	{
	}

	public function add(Depoimento $depoimento): bool
	{
		$sql = 'INSERT INTO depoimentos (foto, mensagem, autor) VALUES (?, ?, ?)';
		$statement = $this->pdo->prepare($sql);
		$statement->bindValue(1, $depoimento['foto']);
		$statement->bindValue(2, $depoimento['mensagem']);
		$statement->bindValue(3, $depoimento['autor']);

		$result = $statement->execute();
		$id = $this->pdo->lastInsertId();

		$depoimento->setId(intval($id));

		return $result;
	}

	public function remove(int $id): bool
	{
		$sql = 'DELETE FROM depoimentos WHERE id = ?';
		$statement = $this->pdo->prepare($sql);
		$statement->bindValue(1, $id);

		return $statement->execute();
	}

	public function update(Depoimento $depoimento): bool
	{
		$sql = "UPDATE depoimentos SET
                  foto = :foto,
                  mensagem = :mensagem
				  autor = :autor
              WHERE id = :id;";
		$statement = $this->pdo->prepare($sql);

		$statement->bindValue(':foto', $depoimento['foto']);
		$statement->bindValue(':mensagem', $depoimento['mensagem']);
		$statement->bindValue(':autor', $depoimento['autor']);
		$statement->bindValue(':id', $depoimento->id, PDO::PARAM_INT);

		return $statement->execute();
	}

	/**
	 * @return Depoimento[]
	 */
	public function all(): array
	{
		$depoimentoList = $this->pdo
			->query('SELECT * FROM depoimentos;')
			->fetchAll(PDO::FETCH_ASSOC);
		return array_map(
			$this->hydrateDepoimento(...),
			$depoimentoList
		);
	}

	public function find(int $id)
	{
		$statement = $this->pdo->prepare('SELECT * FROM depoimentos WHERE id = ?;');
		$statement->bindValue(1, $id, PDO::PARAM_INT);
		$statement->execute();

		return $this->hydrateDepoimento($statement->fetch(PDO::FETCH_ASSOC));
	}

	private function hydrateDepoimento(array $depoimento): Depoimento
	{
		$depoimentoHidratado = new Depoimento($depoimento['foto'], $depoimento['mensagem'], $depoimento['autor']);
		$depoimentoHidratado->setId($depoimento['id']);

		return $depoimentoHidratado;
	}
}
