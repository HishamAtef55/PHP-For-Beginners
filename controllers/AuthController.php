<?php

namespace Controllers;

use Core\App;
use Core\Database;
use Core\Validator;
use Core\Authentication;
use Core\Session;
use Core\Validation\FormValidation;

class AuthController
{
    public readonly Database $pdo;

    public function __construct()
    {
        $this->pdo = App::resolve(Database::class);
    }

    public function getRegister()
    {
        return view('Auth/register.blade.php', [
            'errors' => Session::get('errors'),
            'heading' => 'Registration'
        ]);
    }

    public function saveRegister()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $user_name = $_POST['user_name'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $form = new FormValidation();
            if ($form->validateRegister($email, $password, $user_name)) {
                $query = "INSERT INTO users (email,password,username) VALUES (:email,:password,:username)";
                $this->pdo->query($query, [
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_BCRYPT),
                    'username' => $user_name
                ]);
                $query = "SELECT * FROM users WHERE email = :email";

                $user = $this->pdo->query($query, [
                    'email' => $email
                ])->find();

                (new Authentication)->login($user);
                redirect('/');
            }
            Session::flash('errors', $form->errors());
            Session::flash('old', [
                'email' => $_POST['email'],
                'user_name' => $_POST['user_name'],
            ]);
            redirect('/register');
        }
    }

    public function getLogin()
    {

        return view('Auth/login.blade.php', [
            'errors' =>  Session::get('errors'),
            'heading' => 'Registration'
        ]);
    }

    public function createSession()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $form = new FormValidation();
            if ($form->validateLogin($email, $password)) {
                if ((new Authentication)->attempt($email, $password)) {
                    redirect('/');
                }
                $form->error('email', 'No matching account found for that email address and password.');
            }
            Session::flash('errors', $form->errors());
            Session::flash('old', [
                'email' => $_POST['email']
            ]);
            redirect('/login');
        }
    }

    public function logout()
    {
        if ($_SESSION['user']) {
            (new Authentication)->logout();
            exit();
        }
    }
}
