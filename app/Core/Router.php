<?php

declare(strict_types=1);

namespace App\Core;

class Router
{
    private string $prefix = '';

    /** @var Route[] */
    private array $routes = [];

    public function __construct(string $prefix = '')
    {
        $this->prefix = trim($prefix, '/');
    }

    private function addRoute(RequestMethod $method, string $uri, string $className, string $action): void
    {
        $uri = '/' . $this->prefix . trim($uri, '/');
        $this->addRouteByObject(new Route($method, $uri, $className, $action));
    }

    private function addRouteByObject(Route $route): void
    {
        $this->routes[] = $route;
    }

    public function merge(Router $router): static
    {
        foreach ($router->getRoutes() as $route) {
            $this->addRouteByObject($route);
        }

        return $this;
    }

    public function findRoute(RequestMethod $method, string $uri): ?Route
    {
        foreach ($this->routes as $route) {
            if($route->getMethod()->value === $method->value && $route->getUri() === $uri) {
                return $route;
            }
        }

        return null;
    }

    public function addGet(string $uri, string $className, string $action): static
    {
        $this->addRoute(RequestMethod::GET, $uri, $className, $action);

        return $this;
    }

    public function addPost(string $uri, string $className, string $action): static
    {
        $this->addRoute(RequestMethod::POST, $uri, $className, $action);

        return $this;
    }

    public function addPut(string $uri, string $className, string $action): static
    {
        $this->addRoute(RequestMethod::PUT, $uri, $className, $action);

        return $this;
    }

    public function addPatch(string $uri, string $className, string $action): static
    {
        $this->addRoute(RequestMethod::PATCH, $uri, $className, $action);

        return $this;
    }

    public function addDelete(string $uri, string $className, string $action): static
    {
        $this->addRoute(RequestMethod::DELETE, $uri, $className, $action);

        return $this;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

}