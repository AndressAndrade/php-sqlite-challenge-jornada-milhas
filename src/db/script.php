<?php

declare(strict_types=1);

namespace jornada\mvc\db;

$pdo = Connection::get();

$pdo->exec('CREATE TABLE depoimentos (id INTEGER PRIMARY KEY, foto TEXT, mensagem TEXT, autor TEXT);');

$sql = 'INSERT INTO depoimentos (foto, mensagem, autor) VALUES (?,?,?);';
$statement = $pdo->prepare($sql);
$statement->bindValue(1, "http://google.com.br");
$statement->bindValue(2, "Adorei utilizar o serviço");
$statement->bindValue(3, "Andressa Andrade");
$statement->execute();

exit();
