<?php

namespace App\Core\Response;

class JsonResponse implements ResponseInterface
{
    public function __construct(
        private array $data,
        private int $statusCode = 200,
    )
    {
    }

    public function render()
    {
        header('Content-Type: application/json');
        http_response_code($this->statusCode);

        echo json_encode($this->data);
    }
}