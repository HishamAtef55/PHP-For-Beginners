<?php

use Core\App;
use Core\Database;
use Core\Validator;

$email = $_POST['email'];
$password = $_POST['password'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!Validator::email($email)) {
        $errors['email'] = 'please enter avalida email';
    }

    if (!Validator::string($_POST['password'], 1, 255)) {
        $errors['password'] = 'please enter avalida password';
    }

    if (!empty($errors)) {
        return view('Auth/login.blade.php', [
            'errors' => $errors,
            'heading' => 'Registration'
        ]);
    }


    $pdo = App::resolve(Database::class);

    $query = "SELECT * FROM users WHERE email = :email";

    $user = $pdo->query($query, [
        'email' => $email
    ])->find();

    if (!$user) {
        $errors['email'] = 'Invalida Email Address';
        return view('Auth/login.blade.php', [
            'errors' => $errors,
            'heading' => 'Registration'
        ]);
    }

    if (!password_verify($password, $user['password'])) {
        $errors['password'] = 'Wrogn password';
        return view('Auth/login.blade.php', [
            'errors' => $errors,
            'heading' => 'Registration'
        ]);
    }
    login($user);

    header('location: /');
    exit();
}
