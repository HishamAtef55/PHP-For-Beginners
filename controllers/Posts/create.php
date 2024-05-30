<?php
require base_path('Validator.php');

$config = require base_path('config.php');

$pdo = new Database($config['database']);
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

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
    "errors" => $errors,
]);
