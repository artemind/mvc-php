<?php

namespace App\Exceptions\RenderableExceptions;

use App\Core\Request;
use App\Core\Response\JsonResponse;
use App\Core\Response\ViewResponse;
use Exception;
use Twig\Error\LoaderError;

abstract class AbstractRenderableException extends Exception
{
    abstract protected function getJsonResponse(): ?JsonResponse;

    abstract protected function getViewResponse(): ?ViewResponse;

    public function render(): void
    {
        if(Request::expectsJsonResponse()) {
            $response = $this->getJsonResponse();
        } else {
            $response = $this->getViewResponse();
        }
        if($response === null) {
            throw $this;
        }
        try {
            $response->render();
        } catch (LoaderError $e) {
           throw $this;
        }
    }
}