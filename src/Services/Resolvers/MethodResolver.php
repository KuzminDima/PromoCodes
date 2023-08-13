<?php

declare(strict_types=1);

namespace App\Services\Resolvers;

use App\Services\ContainerInterface;
use ReflectionMethod;

class MethodResolver
{
    public function __construct(
        protected ContainerInterface $container,
        protected object $instance,
        protected string $methodName,
        protected array $defaultArguments = []
    ) {
    }

    /**
     * @throws \ReflectionException
     */
    public function getResult(): mixed
    {
        $method = new ReflectionMethod($this->instance, $this->methodName);

        $argumentResolver = new ArgumentsResolver(
            $this->container,
            $method->getParameters(),
            $this->defaultArguments
        );

        return $method->invokeArgs($this->instance, $argumentResolver->getArguments());
    }
}