<?php

use Core\Database;


$config = require base_path('config.php');

$pdo = new Database($config['database']);
$currentUserId = 33;
if ($_POST['_method'] === 'DELETE') {
    $q = "SELECT * FROM posts where id = :id";

    $id = $_POST['id'];

    $post = $pdo->query($q, ['id' => $id])->findOrFail();

    authorize($post['user_id'] === $currentUserId);

    $query = "DELETE FROM posts WHERE id = :id";

    $statement = $pdo->connection->prepare($query);

    $statement->bindParam(':id', $post['id']);

    $statement->execute();

    header("location: /posts");

    exit();
}
