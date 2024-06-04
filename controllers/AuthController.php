<?php

namespace Controllers;

use Core\App;
use Core\Database;
use Core\Validator;

class AuthController
{

    public function getRegister()
    {
        return view('Auth/register.blade.php', [
            'errors' => [],
            'heading' => 'Registration'
        ]);
    }

    public function saveRegister()
    {
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
    }

    public function getLogin()
    {

        return view('Auth/login.blade.php', [
            'errors' => [],
            'heading' => 'Registration'
        ]);
    }

    public function createSession()
    {
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
    }

    public function logout()
    {
        if ($_SESSION['user']) {
            logout();
            exit();
        }
    }
}
