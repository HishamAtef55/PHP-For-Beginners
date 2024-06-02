<?php

use Core\App;
use Core\Database;

$pdo = App::resolve(Database::class);

$currentUserId = $_SESSION['user']['id'];;

$id = $_GET['id'];

// find the corresponding note
$q = "SELECT * FROM posts where id = :id";

$id = $_GET['id'];

$params = [
    'id' => $id
];

$post = $pdo->query($q, $params)->findOrFail();

// authorize that the current user can edit the note
authorize($post['user_id'] === $currentUserId);

view('Posts/edit.blade.php', [
    'heading' => 'update post',
    'post' => $post,
    'errors' => []
]);
