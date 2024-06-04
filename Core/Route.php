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
    public function __construct($uri, $action, $method, $middleware = null)
    {
        self::$routes[] = compact('uri', 'action', 'method', 'middleware');
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
        callable|array $action
    ): self {
        return new self($uri, $action, 'GET');
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
        callable|array $action
    ): self {
        return new self($uri, $action, 'POST');
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
        callable|array $action
    ): self {
        return new self($uri, $action, 'DELETE');
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
        callable|array $action
    ): self {
        return new self($uri, $action, 'PATCH');
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
        callable|array $action
    ): self {
        return new self($uri, $action, 'PUT');
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
                if (is_callable($route['action'])) {
                    return call_user_func($route['action']);
                }
                if (is_array($route['action'])) {
                    [$class, $func] = $route['action'];
                    if (class_exists($class)) {
                        $class = new $class();
                        if (method_exists($class, $func)) {
                            return call_user_func([$class, $func], []);
                        }
                    }
                }
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
