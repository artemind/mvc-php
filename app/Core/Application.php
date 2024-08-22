<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Response\JsonResponse;
use App\Core\Response\ResponseInterface;
use App\Core\Response\ViewResponse;
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

    public function handleRequest(): void
    {
        $requestMethod = RequestMethod::from($_SERVER['REQUEST_METHOD']);
        $uri = $_SERVER['REQUEST_URI'];
        $route = $this->router->findRoute($requestMethod, $uri);
        if(!$route) {
            if(!isset($_SERVER['HTTP_ACCEPT']) || !str_contains($_SERVER['HTTP_ACCEPT'], 'application/json')) {
                (new ViewResponse('errors/404.twig', ['title' => '404'], 404))->render();

                return;
            }
            (new JsonResponse([], 404))->render();

            return;
        }
        $controller = new ($route->getClassName());
        $response = $controller->{$route->getAction()}();
        if($response instanceof ResponseInterface) {
            $response->render();

            return;
        }
        if(is_array($response)) {
            (new JsonResponse($response))->render();

            return;
        }
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