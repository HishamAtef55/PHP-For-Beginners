<?php

use Core\Database;

$config = require base_path("config.php");

$db = new Database($config['database']);

$id = $_GET['id'];

$q = "SELECT * FROM posts where id = :id";

$id = $_GET['id'];

$params = [
    'id' => $id
];

$post = $db->query($q, $params)->findOrFail();

view('Posts/edit.blade.php', [
    'heading' => 'update post',
    'post' => $post
]);
