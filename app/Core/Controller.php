<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Response\JsonResponse;
use App\Core\Response\ViewResponse;

class Controller
{
    final protected function view(string $view, array $data = [], int $statusCode = 200): ViewResponse
    {
        return new ViewResponse($view, $data, $statusCode);
    }

    final protected function json(array $data = [], int $statusCode = 200): JsonResponse
    {
        return new JsonResponse($data, $statusCode);
    }

}