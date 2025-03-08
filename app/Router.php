<?php

namespace App;

class Router
{
    private $routes = [];
    
    public function add($method, $path, $controller, $action)
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }
    
    public function dispatch($method, $uri)
    {
        // Remove query string from URI if present
        if (strpos($uri, '?') !== false) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }
        
        // Remove trailing slash if not root
        if ($uri !== '/' && substr($uri, -1) === '/') {
            $uri = rtrim($uri, '/');
        }
        
        foreach ($this->routes as $route) {
            // Convert route path to regex pattern
            $pattern = $this->convertRouteToRegex($route['path']);
            
            if ($route['method'] === $method && preg_match($pattern, $uri, $matches)) {
                $params = array_slice($matches, 1);
                $controllerName = $route['controller'];
                $actionName = $route['action'];
                
                // Create controller instance
                $controller = new $controllerName(new \App\Dashboard\DatabaseConnection());
                
                // Call the action with parameters
                call_user_func_array([$controller, $actionName], $params);
                return true;
            }
        }
        
        // No route found
        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
        return false;
    }
    
    private function convertRouteToRegex($route)
    {
        // Convert route parameters like {id} to regex capture groups
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $route);
        return '#^' . $pattern . '$#';
    }
}