<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use jornada\mvc\resources\depoimento\{DepoimentoRepository, DepoimentoController};

$dbPath = __DIR__ . '/../src/db/banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");

$depoimentoRepository = new DepoimentoRepository($pdo);
$depoimentoController = new DepoimentoController($depoimentoRepository);

if ($_SERVER['PATH_INFO'] === '/depoimentos' && $_SERVER['REQUEST_METHOD'] === 'GET') {
	$depoimentoController->list();
}
