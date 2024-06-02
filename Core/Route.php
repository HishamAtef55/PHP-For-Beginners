<?php

declare(strict_types=1);

namespace Core;


use Core\Middleware\Middleware;

class Route
{

    protected static $routes = [];
    /**
     * __construct
     *
     * @param  string $url
     * @param  string $controller
     * @param  string $method
     * @return void
     */
    public function __construct($uri, $controller, $method, $middleware = null)
    {
        self::$routes[] = compact('uri', 'controller', 'method', 'middleware');
    }
    /**
     * get
     *
     * @param  string $uri
     * @param  string $controller
     * @return self
     */
    public static function get(
        string $uri,
        string $controller
    ): self {
        return new self($uri, $controller, 'GET');
    }

    /**
     * post
     *
     * @param  string $uri
     * @param  string $controller
     * @return self
     */
    public static function post(
        string $uri,
        string $controller
    ): self {
        return new self($uri, $controller, 'POST');
    }
    /**
     * delete
     *
     * @param  string $uri
     * @param  string $controller
     * @return self
     */
    public static function delete(
        string $uri,
        string $controller
    ): self {
        return new self($uri, $controller, 'DELETE');
    }
    /**
     * patch
     *
     * @param  string $uri
     * @param  string $controller
     * @return self
     */
    public static function patch(
        string $uri,
        string $controller
    ): self {
        return  new self($uri, $controller, 'PATCH');
    }
    /**
     * put
     *
     * @param  string $uri
     * @param  string $controller
     * @return self
     */
    public static function put(
        string $uri,
        string $controller
    ): self {
        return new self($uri, $controller, 'PUT');
    }
    /**
     * put
     *
     * @param  string $uri
     * @param  string $controller
     * @return self
     */
    /**
     * route
     *
     * @param  string $uri
     * @param  string $method
     * @return void
     */
    public static function route(
        string $uri,
        string $method
    ) {

        foreach (self::$routes as $route) {
            if ($route['uri'] === $uri && $route['method'] === $method) {
                Middleware::resolve($route['middleware']);
                return require base_path($route['controller']);
            }
        }

        self::abort();
    }
    /**
     * abort
     *
     * @param  int $code
     * @return void
     */
    protected static function abort($code = 404)
    {
        http_response_code($code);

        require base_path("views/{$code}.blade.php");

        die();
    }

    /**
     * only
     *
     * @param  string $key
     * @return void
     */
    public function only(
        string $key
    ) {
        self::$routes[array_key_last(self::$routes)]['middleware'] = $key;
    }
}
