<?php
// src/App/Controller/Router.php

namespace App\Controller;

use App\Session;

class Router
{
    private $routes = [];

    public function addRoute(string $method, string $path, $action, array $middleware = [])
    {
        $this->routes[$method][$path] = ['action' => $action, 'middleware' => $middleware];
    }

    public function dispatch(string $method, string $path)
    {
        if($method == "POST" && isset($_POST['_method'])) $method = $_POST['_method'];
        // Extract query parameters from the path
        $queryParameters = [];
        $pathParts = explode('?', $path, 2);
        $path = $pathParts[0];
        if (isset($pathParts[1])) {
            parse_str($pathParts[1], $queryParameters);
        }

        
        if (isset($this->routes[$method][$path])) {
            if($method == "POST"){
                if (!isset($_POST['csrf_token']) || !Session::verifyCsrfToken($_POST['csrf_token'])) {
                    http_response_code(419);
                    include __DIR__.'/../pages/error/419.php';
                    exit;
                }
            }
            $route = $this->routes[$method][$path];
            $action = $route['action'];
            $middlewares = $route['middleware'];

            // Execute middleware
            foreach ($middlewares as $middleware) {
                $middlewareInstance = new $middleware();
                $middlewareInstance->handle($path);
            }

            // Check if the action is an array (class name and method)
            if (is_array($action) && count($action) === 2 && is_string($action[0]) && is_string($action[1])) {
                $class = $action[0];
                $method = $action[1];
                if (class_exists($class)) {
                    $handler = new $class();
                    if (method_exists($handler, $method)) {
                        // Pass query parameters to the method if needed
                        $handler->$method($queryParameters);
                        return;
                    }
                }
                // Handle class or method not found
                http_response_code(404);
                echo 'Class or method not found';
                return;
            }
            
            // Handle case where action is not an array (string class name)
            if (class_exists($action)) {
                $handler = new $action();
                $handler->execute($queryParameters);
            } else {
                // Handle action class not found
                http_response_code(404);
                echo 'Action class not found';
            }
        } else {
            // Handle route not found
            http_response_code(404);
            include __DIR__.'/../pages/error/404.php';
            exit;
        }
    }
}
