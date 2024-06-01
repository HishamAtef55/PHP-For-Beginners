<?php

use Core\Database;

$config = require base_path("config.php");

$pdo = new Database($config['database']);

$query = "DELETE FROM posts WHERE id = :id";

$statement = $pdo->connection->prepare($query);

$statement->bindParam(':id', $_GET['id']);

$statement->execute();


