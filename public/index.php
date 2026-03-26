<?php

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/core/Router/router.php';

use App\Controller\HomeController;

$router = new Router();
$router->get('/', [HomeController::class, 'index']);
$router->run();
