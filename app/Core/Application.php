<?php

declare(strict_types=1);

namespace App\Core;

use Dotenv\Dotenv;

class Application
{
    private Router $router;

    public function __construct(
        private string $basePath,
    )
    {
        $this->router = new Router();
    }

    private function bootstrapConfig(): void
    {
        $dotenv = Dotenv::createImmutable($this->getBasePath());
        $dotenv->load();
    }

    private function bootstrapRouter(): void
    {
        foreach (glob($this->getBasePath() . '/routes/*.php') as $routerFile) {
            $router = require $routerFile;
            if(!($router instanceof Router)) {
                continue;
            }
            $this->router->merge($router);
        }
    }

    public function handleRequest(): mixed
    {
        $requestMethod = RequestMethod::from($_SERVER['REQUEST_METHOD']);
        $uri = $_SERVER['REQUEST_URI'];
        $route = $this->router->findRoute($requestMethod, $uri);
        if(!$route) {
            http_response_code(404);
            //todo add 404 page

            return null;
        }
        $controller = new ($route->getClassName());

        return $controller->{$route->getAction()}();
    }

    public function bootstrap(): void
    {
        $this->bootstrapConfig();
        $this->bootstrapRouter();
    }

    public function getBasePath(): string
    {
        return $this->basePath;
    }
}