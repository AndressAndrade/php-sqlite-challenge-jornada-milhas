<?php

$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");

$pdo->exec('CREATE TABLE depoimentos (id INTEGER PRIMARY KEY, foto TEXT, mensagem TEXT, autor TEXT);');

$sql = 'INSERT INTO depoimentos (foto, mensagem, autor) VALUES (?,?,?);';
$statement = $pdo->prepare($sql);
$statement->bindValue(1, "http://google.com.br");
$statement->bindValue(2, "Adorei utilizar o serviço");
$statement->bindValue(3, "Andressa Andrade");
$statement->execute();

exit();
