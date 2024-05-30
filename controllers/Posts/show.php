<?php


$config = require './config.php';

$currentUserId = 32;

$pdo = new Database($config['database']);

$q = "SELECT * FROM posts where id = :id";

$id = $_GET['id'];

$post = $pdo->query($q, ['id' => $id])->findOrFail();

authorize($post['user_id'] === $currentUserId);

view("Posts/show.blade.php", [
    "heading" => "Posts",
    "post" => $post
]);
