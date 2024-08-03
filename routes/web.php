<?php

declare(strict_types=1);

use App\Core\Router;
use App\Http\Controllers\TestController;

$router = new Router();

$router->addGet('/', TestController::class, 'index');

return $router;