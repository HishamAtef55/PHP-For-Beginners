<?php

use Core\App;
use Core\Database;


$pdo = App::resolve(Database::class);

$currentUserId = 31;


$params = [32, 31, 44];

$q = "SELECT * FROM posts where user_id IN (?,?,?)";
$posts = $pdo->query($q, $params)->get();
view("Posts/index.blade.php", [
    "heading" => "Posts",
    "posts" => $posts
]);
