<?php

namespace App\Exceptions\RenderableExceptions;

use App\Core\Response\ViewResponse;

class NotFoundException extends AbstractHttpRenderableException
{
    protected function getStatusCode(): int
    {
        return 404;
    }

    /**
     * @return mixed
     */
    public function getDefaultMessage(): string
    {
        return 'Not Found';
    }
}