<?php

declare(strict_types=1);

/**
 * Router class for handling routing in a PHP application
 */

class Router
{
    /**
     * @var array The array of routes
     */
    private array $routes = [];

    /**
     * Adds a route to the routing table
     *
     * @param string $method The HTTP method (GET, POST, etc.)
     * @param string $path The URL path
     * @param array $controller The controller and method to handle the route
     */
    public function add(string $method, string $path, array $controller): void
    {
        $path = $this->normalizePath($path);
        $this->routes[] = [
            'path' => $path,
            'method' => strtoupper($method),
            'controller' => $controller,
            'middlewares' => []
        ];
    }

    /**
     * Normalizes a URL path by ensuring it starts and ends with a single slash
     *
     * @param string $path The URL path to normalize
     * @return string The normalized path
     */
    private function normalizePath(string $path): string
    {
        $path = trim($path, '/');
        $path = "/{$path}/";
        return preg_replace('#[/]{2,}#', '/', $path);
    }

    /**
     * Dispatches the route for the given path and executes the associated controller method
     *
     * @param string $path The URL path to dispatch
     */
    public function dispatch(string $path): void
    {
        $path = $this->normalizePath($path);
        $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? '');

        foreach ($this->routes as $route) {
            if (
                preg_match("#^{$route['path']}$#", $path) &&
                $route['method'] === $method
            ) {
                [$class, $function] = $route['controller'];
                $controllerInstance = new $class();
                $controllerInstance->{$function}();
                return;
            }
        }

        // Handle route not found
        http_response_code(404);
        echo "404 Not Found";
    }
}
