<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Response\JsonResponse;
use App\Core\Response\ViewResponse;

class TestController
{
    public function index(): JsonResponse
    {
        return new JsonResponse([
            'action' => 'index'
        ]);
    }

    public function test()
    {
        return [
            'action' => 'test'
        ];
    }

    public function view()
    {
        return new ViewResponse('index.html');
    }
}