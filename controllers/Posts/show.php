<?php

use Core\App;
use Core\Database;

$pdo = App::resolve(Database::class);

$currentUserId = $_SESSION['user']['id'];

// find the corresponding note
$q = "SELECT * FROM posts where id = :id";

$id = $_GET['id'];

$post = $pdo->query($q, ['id' => $id])->findOrFail();

// authorize that the current user can edit the note
authorize($post['user_id'] === $currentUserId);

return view("Posts/show.blade.php", [
    "heading" => "Posts",
    "post" => $post
]);
