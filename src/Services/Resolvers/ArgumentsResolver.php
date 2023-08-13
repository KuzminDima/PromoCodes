<?php

declare(strict_types=1);

namespace App\Services\Resolvers;

use App\Services\ContainerInterface;
use ReflectionParameter;

class ArgumentsResolver
{
    public function __construct(
        protected ContainerInterface $container,
        protected array $arguments,
        protected array $defaultArguments = []
    )
    {
    }

    /**
     * @throws \ReflectionException
     */
    public function getArguments(): array
    {
        return array_map(
            function (ReflectionParameter $parameter) {
                if (array_key_exists($parameter->getName(), $this->defaultArguments)) {
                    return $this->defaultArguments[$parameter->getName()];
                }

                return $parameter->getType() && ! $parameter->getType()->isBuiltin()
                    ? $this->getClassInstance($parameter->getType()->getName())
                    : $parameter->getDefaultValue();
            },
            $this->arguments
        );
    }

    protected function getClassInstance(string $namespace): object
    {
        return (new ClassResolver($this->container, $namespace))->getInstance();
    }
}