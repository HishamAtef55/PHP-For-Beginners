<?php

use Core\App;
use Core\Database;
use Core\Validator;

$pdo = App::resolve(Database::class);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!Validator::string($_POST['body'], 1, 1000)) {
        $errors['body'] = 'body is required';
        return view("Posts/create.blade.php", [
            "heading" => "Create Posts",
            "errors" =>  $errors,
        ]);
    }

    if (empty($errors)) {
        $pdo->query('INSERT INTO posts(title,user_id) VALUES(:title,:user_id)', [
            'title' => $_POST['body'],
            'user_id' => 31
        ]);
        header("location: /posts");
        exit();
    }
}
