<?php

declare(strict_types=1);

namespace App\Router;

use App\Request\ConsoleRequest;
use App\Request\HttpRequest;
use App\Request\RequestInterface;
use App\Router\Exceptions\RouteWasNotFound;

class Router
{
    protected static array $webRoutes = [];
    protected static array $consoleRoutes = [];

    public static function web(string $method, string $route, string|array $binding): void
    {
        static::$webRoutes[$method][] = new RouteBinding($route, $binding);
    }

    public static function console(string $route, string|array $binding): void
    {
        static::$consoleRoutes[] = new RouteBinding($route, $binding);
    }

    public function resolveRoute(RequestInterface $request): RouteBinding
    {
        foreach ($this->getRoutesListByRequest($request) as $routeBinding) {
            /** @var RouteBinding $routeBinding */
            if ($routeBinding->match($request->getPath())) {
                return $routeBinding;
            }
        }

        throw new RouteWasNotFound();
    }

    protected function getRoutesListByRequest(RequestInterface $request): array
    {
        return match (get_class($request)) {
            HttpRequest::class => static::$webRoutes[$request->getMethod()] ?? [],
            ConsoleRequest::class => static::$consoleRoutes,

            default => []
        };
    }
}