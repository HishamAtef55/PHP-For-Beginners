<?php

namespace Core\Middleware;

class Auth
{
    
    /**
     * handle
     *
     * @return void
     */
    public function handle()
    {
        if (!$_SESSION['user'] ?? false) {
            header('location: /register');
            exit();
        }
    }
}
