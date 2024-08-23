<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Response\JsonResponse;
use App\Core\Response\ResponseInterface;
use App\Exceptions\RenderableExceptions\AbstractRenderableException;
use App\Exceptions\RenderableExceptions\NotFoundException;
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
        try {
            $requestMethod = RequestMethod::from($_SERVER['REQUEST_METHOD']);
            $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $route = $this->router->findRoute($requestMethod, $uri);
            if(!$route) {
                throw new NotFoundException('Page Not Found');
            }
            if(!class_exists($route->getClassName())) {
                throw new NotFoundException("Controller {$route->getClassName()} Not Found.");
            }
            $controller = new ($route->getClassName());
            if(!method_exists($controller, $route->getAction())) {
                throw new NotFoundException("Method '{$route->getAction()}' Not Found in '{$route->getClassName()}'");
            }
            $response = $controller->{$route->getAction()}();
            if($response instanceof ResponseInterface) {
                $response->render();

                return;
            }
            if(is_array($response)) {
                (new JsonResponse($response))->render();

                return;
            }
        } catch (AbstractRenderableException $exception) {
            $exception->render();
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