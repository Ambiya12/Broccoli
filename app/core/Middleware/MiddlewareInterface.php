<?php

namespace App\core\Middleware;

interface MiddlewareInterface
{
    /**
     * Exécute le middleware.
     * Doit appeler header() + exit si la condition n'est pas remplie.
     */
    public function handle(): void;
}
