<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use jornada\mvc\resources\depoimento\{DepoimentoRepository, DepoimentoController};

$dbPath = __DIR__ . '/../src/db/banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");

$depoimentoRepository = new DepoimentoRepository($pdo);
$depoimentoController = new DepoimentoController($depoimentoRepository);

$rota = $_SERVER['PATH_INFO'];
$metodo = $_SERVER['REQUEST_METHOD'];

if ($rota === '/depoimentos' && $metodo === 'GET') {
	$depoimentoController->list();
} else if ($rota === '/depoimentos-home' && $metodo === 'GET') {
	$depoimentoController->home();
} else if ($rota === '/depoimento' && $metodo === 'GET') {
	$depoimentoController->get();
} else if ($rota === '/depoimento' && $metodo === 'POST') {
	$depoimentoController->create();
} else if ($rota === '/depoimento' && $metodo === 'PUT') {
	$depoimentoController->edit();
} else if ($rota === '/depoimento' && $metodo === 'DELETE') {
	$depoimentoController->exclude();
}
