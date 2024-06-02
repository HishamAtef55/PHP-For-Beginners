<?php

use Core\App;
use Core\Database;


$pdo = App::resolve(Database::class);

$currentUserId = $_SESSION['user']['id'];

$q = "SELECT * FROM posts where user_id = :user_id";
$posts = $pdo->query($q, [
    'user_id' => $currentUserId
])->get();
view("Posts/index.blade.php", [
    "heading" => "Posts",
    "posts" => $posts
]);
