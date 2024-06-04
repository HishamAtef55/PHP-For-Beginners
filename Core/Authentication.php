<?php

namespace Core;

class Authentication
{
    public readonly Database $pdo;

    public function __construct()
    {
        $this->pdo = App::resolve(Database::class);
    }
    public function attempt($email, $password)
    {
        $query = "SELECT * FROM users WHERE email = :email";

        $user = $this->pdo->query($query, [
            'email' => $email
        ])->find();
        if ($user) {
            if (password_verify($password, $user['password'])) {
                $this->login($user);
                return true;
            }
        }
        return false;
    }

    /**
     * login
     *
     * @param  mixed $user
     * @return void
     */
    function login(
        array $user
    ) {
        return $_SESSION['user'] = [
            'id' => $user['id'],
            'email' => $user['email'],
            'username' => $user['username'],
        ];
        session_regenerate_id();
    }


    /**
     * logout
     *
     * @return void
     */
    function logout()
    {
        session_destroy();
        $params = session_get_cookie_params();
        setcookie('PHPSESSID', "", time() - 3600, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        redirect('/login');
    }
}
