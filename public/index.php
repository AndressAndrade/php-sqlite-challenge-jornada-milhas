<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use jornada\mvc\resources\depoimento\{DepoimentoRepository, DepoimentoController};
use jornada\mvc\db\Connection;

$rota = $_SERVER['PATH_INFO'];
$metodo = $_SERVER['REQUEST_METHOD'];

if ($rota === null) {
	http_response_code(404);
} else if (str_contains($rota, 'depoimento')) {
	$depoimentoRepository = new DepoimentoRepository(Connection::get());
	$depoimentoController = new DepoimentoController($depoimentoRepository);

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
	} else {
		http_response_code(404);
	}
} else {
	http_response_code(404);
}
