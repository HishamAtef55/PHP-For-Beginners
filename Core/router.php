<?php
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$routes = require base_path('routes.php');

routesToController($uri, $routes);
