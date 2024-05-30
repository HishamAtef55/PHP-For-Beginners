<?php

require './Validator.php';
$config = require './config.php';

$pdo = new Database($config['database']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];

    if (!Validator::string($_POST['body'], 1, 1000)) {
        $errors['body'] = 'body is required';
    }

    if (empty($errors)) {
        $pdo->query('INSERT INTO posts(title,user_id) VALUES(:title,:user_id)', [
            'title' => $_POST['body'],
            'user_id' => 31
        ]);
    }
}


view("Posts/create.blade.php", [
    "heading" => "Create Posts",
]);