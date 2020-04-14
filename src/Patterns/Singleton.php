<?php

namespace Crawler\Patterns;

class Singleton
{
    /**
     * @var array
     */
    private static $instances = [];

    private function __construct()
    {
        //
    }

    private function __clone()
    {
        //
    }

    public function __wakeup()
    {
        //
    }

    public static function getInstance()
    {
        $cls = static::class;
        if (! isset(self::$instances[$cls])) {
            return self::$instances[$cls] = new static;
        }

        return self::$instances[$cls];
    }

}
