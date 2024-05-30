<?php


$config = require './config.php';

$pdo = new Database($config['database']);

$params = [32, 31, 44];

$q = "SELECT * FROM posts where user_id IN (?,?,?)";

$posts = $pdo->query($q, $params)->get();

view("Posts/index.blade.php", [
    "heading" => "Posts",
    "posts" => $posts
]);
