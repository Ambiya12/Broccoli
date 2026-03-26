<?php

class Router
{
    private array $routes = [];

    public function get(string $path, callable|array $callback, array $middleware = []): void
    {
        $this->routes['GET'][$path] = ['handler' => $callback, 'middleware' => $middleware];
    }

    public function post(string $path, callable|array $callback, array $middleware = []): void
    {
        $this->routes['POST'][$path] = ['handler' => $callback, 'middleware' => $middleware];
    }

    public function run(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (preg_match('#^/coverage/#', $uri)) {
            return;
        }

        if (!isset($this->routes[$method][$uri])) {
            http_response_code(404);
            echo '404 - Page non trouvée';
            return;
        }

        $route = $this->routes[$method][$uri];

        // Exécution de la pile middleware dans l'ordre de déclaration.
        // Chaque middleware peut interrompre la chaîne via header()/exit.
        foreach ($route['middleware'] as $middlewareClass) {
            (new $middlewareClass())->handle();
        }

        // Dispatch du handler
        $handler = $route['handler'];

        if (is_array($handler) && count($handler) === 2 && is_string($handler[0])) {
            $controller = new $handler[0]();
            $methodName = $handler[1];
            $controller->$methodName();
        } else {
            call_user_func($handler);
        }
    }
}
