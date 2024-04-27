<?php
// index.php
require_once 'vendor/autoload.php';

use App\Session;
use App\Controller\Router;
use App\Action\UserActions;

Session::start();

// Initialize router
$router = new Router();

$router->addRoute('GET', '/users', [UserActions::class, 'index']);
$router->addRoute('GET', '/users/create', [UserActions::class, 'create']);
$router->addRoute('GET', '/users/edit', [UserActions::class, 'edit']);
$router->addRoute('POST', '/users/store', [UserActions::class, 'store']);
$router->addRoute('POST', '/users/update', [UserActions::class, 'update']);
$router->addRoute('DELETE', '/users/delete', [UserActions::class, 'delete']);

// Dispatch request
$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['REQUEST_URI'];

$router->dispatch($method, $path);
