<?php

declare(strict_types=1);

$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");

$pdo->exec('CREATE TABLE destinos (id INTEGER PRIMARY KEY, foto TEXT, nome TEXT, preco FLOAT);');

$sql = 'INSERT INTO destinos (foto, nome, preco) VALUES (?,?,?);';
$statement = $pdo->prepare($sql);
$statement->bindValue(1, "http://google.com.br");
$statement->bindValue(2, "Japão");
$statement->bindValue(3, 3500.95);
$statement->execute();

$pdo->exec('CREATE TABLE depoimentos (id INTEGER PRIMARY KEY, foto TEXT, mensagem TEXT, autor TEXT);');

$sql = 'INSERT INTO depoimentos (foto, mensagem, autor) VALUES (?,?,?);';
$statement = $pdo->prepare($sql);
$statement->bindValue(1, "http://google.com.br");
$statement->bindValue(2, "Adorei utilizar o serviço");
$statement->bindValue(3, "Andressa Andrade");
$statement->execute();

exit();
