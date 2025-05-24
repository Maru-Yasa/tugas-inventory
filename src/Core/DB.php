<?php

namespace Maru\Inventory\Core;

use Medoo\Medoo;

class DB extends Medoo
{
    protected static ?DB $instance = null;

    public static function init(array $config)
    {
        self::$instance = new self($config);
    }

    public static function make(): DB
    {
        $config = require ROOT_PATH . '/config.php';
        DB::init($config['database']);

        if (!self::$instance) {
            throw new \Exception("DB not initialized. Call DB::init() first.");
        }

        return self::$instance;
    }
}
