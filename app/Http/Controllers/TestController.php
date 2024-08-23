<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Controller;
use App\Core\Response\JsonResponse;
use App\Core\Response\ViewResponse;

class TestController extends Controller
{
    public function testJson(): JsonResponse
    {
        return $this->json([
            'action' => 'testJson',
        ]);
    }

    public function testArray(): array
    {
        return [
            'action' => 'testArray'
        ];
    }

    public function testView(): ViewResponse
    {
        return new ViewResponse('index.twig', ['title' => 'Test Page']);
    }
}