<?php

use Core\Database;

require base_path('Core/Validator.php');


$config = require base_path("config.php");

$pdo = new Database($config);

dd(explode("&", $_SERVER['QUERY_STRING']));
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!Validator::string($_POST['title'], 1, 100)) {
        $errors['error'] = 'title is required';
    }
    if (empty($errors)) {
        $q = "UPDATE posts SET title = :title WHERE id=:id";
        $statement = $pdo->connection->prepare($q);
        $statement->bindParam(':title', $_POST['title']);
        $statement->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        if ($statement->execute()) {
            echo 'The publisher has been updated successfully!';
        }
    }
}
