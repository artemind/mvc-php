<?php

namespace App\Exceptions\RenderableExceptions;

use App\Core\Request;
use App\Core\Response\JsonResponse;
use App\Core\Response\ViewResponse;
use Exception;

abstract class AbstractHttpRenderableException extends AbstractRenderableException
{
    abstract protected function getStatusCode(): int;

    protected function getDefaultMessage(): string
    {
        return '';
    }

    protected function getResponseMessage(): string
    {
        return $this->getMessage() ?: $this->getDefaultMessage();
    }

    protected function getJsonResponse(): ?JsonResponse
    {
        $data = [
            'status_code' => $this->getStatusCode(),
            'message' => $this->getResponseMessage(),
        ];
        if(filter_var($_ENV['APP_DEBUG'], FILTER_VALIDATE_BOOLEAN)) {
            $data['trace'] = $this->getTrace();
        }
        return new JsonResponse($data, $this->getStatusCode());
    }

    protected function getViewResponse(): ?ViewResponse
    {
        return new ViewResponse("errors/{$this->getStatusCode()}.twig", ['message' => $this->getResponseMessage()], $this->getStatusCode());
    }
}