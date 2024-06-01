<?php

declare(strict_types=1);


namespace Core;

class Container
{
    protected static $bindings = [];
    /**
     * bind
     *
     * @param  string $key
     * @param  callable $resolve
     * @return void
     */
    public function bind(
        string $key,
        callable $resolve
    ): void {
        if (!is_callable($resolve)) {
            throw new \Exception("Error Processing Request", 1);
        }
        self::$bindings[$key]  = $resolve;
    }

    /**
     * resolve
     * @param string $key
     * @return object
     */
    public static function resolve(
        string $key
    ) {
        if (!array_key_exists($key, self::$bindings)) {
            throw new \Exception("Error Processing Request", 1);
        }

        $resolver = self::$bindings[$key];

        return call_user_func($resolver);
    }
}
