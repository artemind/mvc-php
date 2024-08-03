<?php

declare(strict_types=1);

namespace App\Core;

class Route
{
    public function __construct(
        private RequestMethod $method,
        private string $uri,
        private string $className,
        private string $action,
    )
    {
    }

    public function getMethod(): RequestMethod
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getClassName(): string
    {
        return $this->className;
    }

    public function getAction(): string
    {
        return $this->action;
    }
}