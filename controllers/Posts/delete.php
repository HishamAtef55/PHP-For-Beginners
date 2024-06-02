<?php

use Core\App;
use Core\Database;


$pdo = App::resolve(Database::class);

$currentUserId = $_SESSION['user']['id'];
if ($_POST['_method'] === 'DELETE') {
    // find the corresponding note
    $q = "SELECT * FROM posts where id = :id";

    $id = $_POST['id'];

    $post = $pdo->query($q, ['id' => $id])->findOrFail();

    // authorize that the current user can edit the note
    authorize($post['user_id'] === $currentUserId);

    $query = "DELETE FROM posts WHERE id = :id";

    $statement = $pdo->connection->prepare($query);

    $statement->bindParam(':id', $post['id']);

    $statement->execute();

    header("location: /posts");

    exit();
}
