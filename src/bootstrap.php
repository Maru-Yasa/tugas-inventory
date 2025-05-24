<?php
use Maru\Inventory\Core\DB;

$valid_username = 'admin';
$valid_password = 'secret';


require __DIR__ . '/../vendor/autoload.php';
define('ROOT_PATH', dirname(__DIR__) . '/src/');

if (php_sapi_name() != 'cli') {
    // if (
    //     !isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) ||
    //     $_SERVER['PHP_AUTH_USER'] !== $valid_username || $_SERVER['PHP_AUTH_PW'] !== $valid_password
    // ) {
    //     header('WWW-Authenticate: Basic realm="Restricted Area"');
    //     header('HTTP/1.0 401 Unauthorized');
    //     echo 'Unauthorized';
    //     exit;
    // }
    $router = require ROOT_PATH . '/route.php';
}

$config = require ROOT_PATH . '/config.php';

DB::init($config['database']);