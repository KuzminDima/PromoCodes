<?php

declare(strict_types=1);

namespace App;

use App\Request\RequestInterface;
use App\Response\ResponseInterface;
use App\Router\RouteBinding;
use App\Router\Router;
use App\Services\Container;
use Exception;

class Kernel
{
    public function __construct(
        protected Container $serviceContainer
    ) {
    }

    /**
     * @throws \ReflectionException
     */
    public function handle(RequestInterface $request): ResponseInterface
    {
        /** @var RouteBinding $route */
        $route = $this->serviceContainer->resolve(Router::class)
            ->resolveRoute($request);

        $response = $this->serviceContainer->resolveMethod(
            $this->serviceContainer->resolve(
                $route->getHandler()
            ),
            $route->getHandlerMethod()
        );

        if (! ($response instanceof ResponseInterface)) {
            throw new Exception(
                'The handler must return an object that implements the ' . ResponseInterface::class . ' interface.'
            );
        }

        return $response;
    }
}