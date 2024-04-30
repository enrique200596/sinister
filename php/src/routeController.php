<?php
require_once 'route.php';

class RouteController
{
    private array $routes;

    public function __construct()
    {
        $this->setRoutes([]);
    }

    public function setRoutes(array $routes): void
    {
        $this->routes = $routes;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function getRoute(string $routeName): Route
    {
        return $this->routes[$routeName];
    }

    public function checkRoute(string $routeName)
    {
        return isset($this->routes[$routeName]);
    }

    public function addRoute(Route $route)
    {
        $this->routes[$route->getName()] = $route;
    }
}
