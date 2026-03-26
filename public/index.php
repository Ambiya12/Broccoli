<?php

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/core/Router/router.php';

use App\Controller\AuthController;
use App\Controller\HomeController;
use App\core\Middleware\AdminMiddleware;
use App\core\Middleware\AuthMiddleware;

$router = new Router();

// Routes publiques
$router->get('/',          [HomeController::class, 'index']);
$router->get('/register',  [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/login',     [AuthController::class, 'showLogin']);
$router->post('/login',    [AuthController::class, 'login']);

// Routes protégées — utilisateur authentifié
$router->get('/dashboard', [AuthController::class, 'dashboard'], [AuthMiddleware::class]);
$router->get('/logout',    [AuthController::class, 'logout'],    [AuthMiddleware::class]);

// Routes protégées — admin uniquement (exemple, décommenter pour utiliser)
// $router->get('/admin', [AdminController::class, 'index'], [AuthMiddleware::class, AdminMiddleware::class]);

$router->run();
