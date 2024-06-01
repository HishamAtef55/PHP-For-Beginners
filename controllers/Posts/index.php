<?php

use Core\Database;

$config = require base_path('config.php');

$pdo = new Database($config['database']);
$currentUserId = 31;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $q = "SELECT * FROM posts where id = :id";

    $id = $_POST['id'];

    $post = $pdo->query($q, ['id' => $id])->findOrFail();

    authorize($post['user_id'] === $currentUserId);

    $query = "DELETE FROM posts WHERE id = :id";

    $statement = $pdo->connection->prepare($query);

    $statement->bindParam(':id', $post['id']);

    $statement->execute();
}
$params = [32, 31, 44];

$q = "SELECT * FROM posts where user_id IN (?,?,?)";
$posts = $pdo->query($q, $params)->get();
view("Posts/index.blade.php", [
    "heading" => "Posts",
    "posts" => $posts
]);
