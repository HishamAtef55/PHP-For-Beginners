<?php

use Core\Container;
use Core\Database;

$container = new Container();

$container->bind(Database::class, function () {
    $config = [
        'host' => $_ENV['DB_HOST'],
        'port' => $_ENV['DB_PORT'],
        'dbname' => $_ENV['DB_NAME'],
        'charset' => $_ENV['DB_CHARSET']
    ];
    return new Database($config);
});
