<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Core\Application;

$app = new Application(
    realpath(__DIR__ . '/../')
);

$app->bootstrap();

$app->handleRequest();