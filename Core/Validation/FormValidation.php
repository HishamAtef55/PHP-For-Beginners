<?php

namespace Core\Validation;

use Core\App;
use Core\Database;
use Core\Validator;

class FormValidation
{
    protected $errors = [];
    public readonly Database $pdo;

    public function __construct()
    {
        $this->pdo = App::resolve(Database::class);
    }
    public function validateRegister($email, $pasword, $username)
    {
        if (Validator::email($email)) {
            $query = "SELECT * FROM users WHERE email = :email";
            $user = $this->pdo->query($query, [
                'email' => $email
            ])->find();
            if ($user) {
                $this->errors['email'] = 'Email has already been taken';
                return false;
            }
            return true;
        } else {
            $this->errors['email'] = 'please enter avalida email';
        }

        if (!Validator::string($pasword, 1, 255)) {
            $this->errors['password'] = 'please enter avalida password';
        }

        if (!Validator::string($username, 1, 255)) {
            $this->errors['user_name'] = 'please enter avalida user name';
        }
        return empty($this->errors);
    }

    public function validateLogin($email, $pasword)
    {
        if (!Validator::email($email)) {
            $this->errors['email'] = 'please enter avalida email';
        }

        if (!Validator::string($pasword, 1, 255)) {
            $this->errors['password'] = 'please enter avalida password';
        }

        return empty($this->errors);
    }

    public function errors()
    {
        return $this->errors;
    }

    public function error($key, $message)
    {
        $this->errors[$key] = $message;
    }
}
