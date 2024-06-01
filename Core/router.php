<?php

namespace Core;

class Router
{

    protected static $routes = [];
    /**
     * __construct
     *
     * @param  mixed $url
     * @param  mixed $controller
     * @param  mixed $method
     * @return void
     */
    public function __construct($uri, $controller, $method)
    {
        self::$routes[] = compact('uri', 'controller', 'method');
    }
    /**
     * get
     *
     * @param  mixed $uri
     * @param  mixed $controller
     * @return void
     */
    public static function get($uri, $controller)
    {
        new self($uri, $controller, 'GET');
    }

    public static function post($uri, $controller)
    {
        new self($uri, $controller, 'POST');
    }

    public static function delete($uri, $controller)
    {
        new self($uri, $controller, 'DELETE');
    }

    public static function patch($uri, $controller)
    {
        new self($uri, $controller, 'PATCH');
    }

    public static function put($uri, $controller)
    {
        new self($uri, $controller, 'PUT');
    }

    public static function route($uri, $method)
    {

        foreach (self::$routes as $route) {
            if ($route['uri'] === $uri && $route['method'] === $method) {
                return require base_path($route['controller']);
            } elseif ($route['uri'] === $uri && $route['method'] != $method) {
                self::abort(405);
            }
        }

        self::abort();
    }
    protected static function abort($code = 404)
    {
        http_response_code($code);

        require base_path("views/{$code}.blade.php");

        die();
    }
}