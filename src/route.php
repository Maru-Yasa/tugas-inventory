<?php
namespace Maru\Inventory;
use Maru\Inventory\Controllers\IndexController;
use Maru\Inventory\Controllers\PosController;
use Maru\Inventory\Core\Router;

$router = new Router();

$router->get('/', IndexController::class, 'index');

$router->get('/pos', PosController::class, 'index');
$router->post('/pos', PosController::class, 'create');

$router->get('/inventory', IndexController::class, 'index');
$router->get('/inventory/create', IndexController::class, 'create');
$router->post('/inventory/create', IndexController::class, 'create');
$router->get('/inventory/edit', IndexController::class, 'edit');
$router->post('/inventory/edit', IndexController::class, 'edit');
$router->post('/inventory/destroy', IndexController::class, 'destroy');

$router->dispatch();