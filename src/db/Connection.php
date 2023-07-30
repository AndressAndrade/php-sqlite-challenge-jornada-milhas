<?php

declare(strict_types=1);

namespace jornada\mvc\db;

use PDO;

class Connection
{
	public static function get()
	{
		$dbPath = __DIR__ . '/banco.sqlite';
		$pdo = new PDO("sqlite:$dbPath");
		return $pdo;
	}
}
