<?php

declare(strict_types=1);

use App\Core\Router;
use App\Http\Controllers\TestController;

$router = new Router();

$router->addGet('/json', TestController::class, 'testJson');

$router->addGet('/array', TestController::class, 'testArray');

$router->addGet('/view', TestController::class, 'testView');

return $router;