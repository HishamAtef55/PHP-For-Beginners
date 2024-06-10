<?php

use Core\Response;

/**
 * dd
 *
 * @param  mixed $value
 * @return void
 */
function dd(mixed $value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";

    die();
}

/**
 * urlIs
 *
 * @param  string $value
 * @return bool
 */
function urlIs(string $value): bool
{
    return $_SERVER['REQUEST_URI'] === $value;
}

/**
 * abort
 *
 * @param  int $code
 */
function abort(
    int $code = 404
) {
    http_response_code($code);

    require "./views/{$code}.blade.php";

    die();
}

/**
 * routesToController
 * @param  string $uri
 * @param  array $routes
 * @return void
 */
function routesToController(
    string $uri,
    array $routes
) {
    if (array_key_exists($uri, $routes)) {
        require base_path($routes[$uri]);
    } else {
        abort();
    }
}


/**
 * authorize
 *
 * @param  bool $condition
 * @return void
 */
function authorize(
    bool $condition
): void {
    if (!$condition) {
        abort(Response::FORBIDDEN);
    }
}

/**
 * base_path
 *
 * @param  string $path
 * @return string
 */
function base_path(
    string $path
): string {
    return BASE_PATH . $path;
}

function view($path, $attribute = [])
{
    extract($attribute);
    require base_path("views/" . $path);
}

// spl_autoload_register(function ($class) {
//     require base_path("{$class}.php");
// });

function redirect($path)
{
    header("location: {$path}");
    exit();
}
function old($key)
{
    return Core\Session::get('old')[$key] ?? '';
}
