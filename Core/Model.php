<?php

namespace Core;

abstract class Model
{
    public readonly Database $pdo;
    public int $currentUserId;
    public function __construct()
    {
        $this->pdo = App::resolve(Database::class);
        $this->currentUserId =  $_SESSION['user']['id'];
    }
}
