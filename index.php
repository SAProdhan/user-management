<?php
// index.php
require_once 'vendor/autoload.php';

use App\Session;
use App\Controller\Router;
use App\Action\UserActions;

Session::start();

// Initialize router
$router = new Router();


$router->addRoute('GET', '/', [LoginActions::class, 'index']);
$router->addRoute('GET', '/login', [LoginActions::class, 'index']);
$router->addRoute('POST', '/login', [LoginActions::class, 'login']);
$router->addRoute('GET', '/logout', [LoginActions::class, 'logout']);

$router->addRoute('GET', '/profile', [ProfileActions::class, 'index'], [AuthMiddleware::class]);
$router->addRoute('POST', '/profile', [ProfileActions::class, 'update'], [AuthMiddleware::class]);
$router->addRoute('DELETE', '/profile', [ProfileActions::class, 'destroy'], [AuthMiddleware::class]);
$router->addRoute('GET', '/users', [UserActions::class, 'index'], [AuthMiddleware::class]);

$router->addRoute('GET', '/users/create', [UserActions::class, 'create'], [AuthMiddleware::class]);
$router->addRoute('GET', '/users/edit', [UserActions::class, 'edit'], [AuthMiddleware::class]);
$router->addRoute('POST', '/users/store', [UserActions::class, 'store'], [AuthMiddleware::class]);
$router->addRoute('POST', '/users/update', [UserActions::class, 'update'], [AuthMiddleware::class]);
$router->addRoute('DELETE', '/users/delete', [UserActions::class, 'delete'], [AuthMiddleware::class]);

// Dispatch request
$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['REQUEST_URI'];

$router->dispatch($method, $path);
