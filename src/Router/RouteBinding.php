<?php

declare(strict_types=1);

namespace App\Router;

use InvalidArgumentException;

class RouteBinding
{
    protected string $route;
    protected string $handler;
    protected string $handlerMethod;

    public function __construct(string $route, string|array $binding)
    {
        $this->route = trim($route, '/');

        if (is_string($binding) && ! str_contains($binding, ':')) {
            throw new InvalidArgumentException('Invalid binding.');
        }

        if (is_array($binding) && count($binding) !== 2) {
            throw new InvalidArgumentException('Invalid binding.');
        }

        [$this->handler, $this->handlerMethod] = is_string($binding) ? explode(':', $binding) : $binding;
    }

    public function match(string $url): bool
    {
        return $this->route === trim($url, '/');
    }

    public function getHandler(): string
    {
        return $this->handler;
    }

    public function getHandlerMethod(): string
    {
        return $this->handlerMethod;
    }
}