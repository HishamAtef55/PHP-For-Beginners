<?php

namespace Core\Middleware;

class Guest
{

    /**
     * handle
     *
     * @return void
     */
    public function handle()
    {
        if ($_SESSION['user'] ?? false) {
            header('location: /');
            exit();
        }
    }
}
