<?php

namespace App\Controller;

use App\core\Middleware\AuthMiddleware;

class RecipeController
{
    public function index(): void
    {
        $isLoggedIn = (new AuthMiddleware())->isAuthenticated();
        require_once __DIR__ . '/../views/recipe.php';
    }
}
