<?php

use Core\App;
use Core\Database;
use Core\Validator;

$email = $_POST['email'];
$password = $_POST['password'];
$user_name = $_POST['user_name'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!Validator::email($email)) {
        $errors['email'] = 'please enter avalida email';
    }

    if (!Validator::string($_POST['password'], 1, 255)) {
        $errors['password'] = 'please enter avalida password';
    }

    if (!Validator::string($_POST['user_name'], 1, 255)) {
        $errors['user_name'] = 'please enter avalida user name';
    }

    if (!empty($errors)) {
        return view('Auth/register.blade.php', [
            'errors' => $errors,
            'heading' => 'Registration'
        ]);
    }


    $pdo = App::resolve(Database::class);

    $query = "SELECT * FROM users WHERE email = :email";

    $user = $pdo->query($query, [
        'email' => $email
    ])->find();

    if ($user) {
        $errors['email'] = 'user already exists';
        return view('Auth/register.blade.php', [
            'errors' => $errors,
            'heading' => 'Registration'
        ]);
    } else {
        $query = "INSERT INTO users (email,password,username) VALUES (:email,:password,:username)";

        $pdo->query($query, [
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'username' => $user_name
        ]);
        $query = "SELECT * FROM users WHERE email = :email";

        $user = $pdo->query($query, [
            'email' => $email
        ])->find();

        login($user);
        header('location: /');
        exit();
    }
}
