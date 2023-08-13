<?php

declare(strict_types=1);

namespace App\Services\Resolvers;

use App\Services\ContainerInterface;
use ReflectionClass;

class ClassResolver
{
    public function __construct(
        protected ContainerInterface $container,
        protected string $namespace,
        protected array $defaultArguments = []
    ) {
    }

    /**
     * @throws \ReflectionException
     */
    public function getInstance(): ?object
    {
        if ($this->container->has($this->namespace)) {
            $binding = $this->container->get($this->namespace);

            if (is_object($binding)) {
                return $binding;
            }

            $this->namespace = $binding;
        }

        $reflectionClass = new ReflectionClass($this->namespace);
        $constructor = $reflectionClass->getConstructor();

        if ($constructor && $constructor->isPublic()) {
            $constructorParameters = $constructor->getParameters();

            if (count($constructorParameters) > 0) {
                $this->defaultArguments = (new ArgumentsResolver(
                    $this->container,
                    $constructorParameters,
                    $this->defaultArguments
                ))->getArguments();
            }

            return $reflectionClass->newInstanceArgs($this->defaultArguments);
        }

        return $reflectionClass->newInstanceWithoutConstructor();
    }
}