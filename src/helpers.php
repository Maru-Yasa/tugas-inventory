<?php
namespace Maru\Inventory;

use Maru\Inventory\Core\Request;

function request(string $key = null, $default = null): Request
{
    static $instance = null;

    if (!$instance) {
        $instance = new Request();
    }

    if (is_null($key)) {
        return $instance;
    }

    return $instance->input($key, $default);
}
