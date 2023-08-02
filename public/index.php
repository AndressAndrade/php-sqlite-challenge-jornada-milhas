<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use \jornada\mvc\resources\depoimento\{DepoimentoRepository, DepoimentoController};
use \jornada\mvc\resources\destino\{DestinoRepository, DestinoController};
use \jornada\mvc\db\Connection;

$rota = $_SERVER['PATH_INFO'] ?? '/';
$metodo = $_SERVER['REQUEST_METHOD'];

if (str_contains($rota, 'depoimento')) {
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
} else if (str_contains($rota, 'destino')) {
	$destinoRepository = new DestinoRepository(Connection::get());
	$destinoController = new DestinoController($destinoRepository);

	if ($rota === '/destinos' && $metodo === 'GET') {
		$destinoController->list();
	} else if ($rota === '/destino' && $metodo === 'GET') {
		$destinoController->get();
	} else if ($rota === '/destino' && $metodo === 'POST') {
		$destinoController->create();
	} else if ($rota === '/destino' && $metodo === 'PUT') {
		$destinoController->edit();
	} else if ($rota === '/destino' && $metodo === 'DELETE') {
		$destinoController->exclude();
	} else {
		http_response_code(404);
	}
} else {
	http_response_code(404);
}
