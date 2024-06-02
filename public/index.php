<?php

session_start();


use Core\Database;
use Core\Route;

const BASE_PATH = __DIR__ . '/../';
require BASE_PATH . 'Core/functions.php';
require base_path('bootstrap.php');


require base_path('web.php');
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];
Route::route($uri, $method);
