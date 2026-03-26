<?php

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/core/Router/router.php';

use App\Controller\AuthController;
use App\Controller\HomeController;

$router = new Router();

$router->get('/',          [HomeController::class, 'index']);

$router->get('/register',  [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);

$router->get('/login',     [AuthController::class, 'showLogin']);
$router->post('/login',    [AuthController::class, 'login']);

$router->get('/dashboard', [AuthController::class, 'dashboard']);
$router->get('/logout',    [AuthController::class, 'logout']);

$router->run();
