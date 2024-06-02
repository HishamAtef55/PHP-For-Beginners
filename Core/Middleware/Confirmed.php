<?php

namespace Core\Middleware;

use Core\App;
use Core\Database;

class Confirmed
{
    
    /**
     * handle
     *
     * @return void
     */
    public function handle()
    {
        $pdo = App::resolve(Database::class);
        $currentUserId = $_SESSION['user']['id'];
        $q = "SELECT * FROM users where id = :id";
        $user = $pdo->query($q, [
            'id' => $currentUserId
        ])->findOrFail();
        if ($user['confirmed'] == false) {
            header('location: /');
            exit();
        }
    }
}
