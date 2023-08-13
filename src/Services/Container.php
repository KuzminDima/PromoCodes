<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\Resolvers\ClassResolver;
use App\Services\Resolvers\MethodResolver;

class Container implements ContainerInterface
{
    protected array $bindings = [];

    public static function getInstance(): static
    {
        static $instance = null;

        if (is_null($instance)) {
            $instance = new static();
        }

        return $instance;
    }

    public function bind(string $id, object|string $binding): Container
    {
        $this->bindings[$id] = $binding;

        return $this;
    }

    public function get(string $id): object|string|null
    {
        return $this->bindings[$id] ?? null;
    }

    public function has(string $id): bool
    {
        return array_key_exists($id, $this->bindings);
    }

    /**
     * @throws \ReflectionException
     */
    public function resolve(string $namespace, array $defaultArguments = []): object
    {
        return (new ClassResolver($this, $namespace, $defaultArguments))->getInstance();
    }

    /**
     * @throws \ReflectionException
     */
    public function resolveMethod(object $instance, string $methodName, array $defaultArguments = [])
    {
        return (new MethodResolver($this, $instance, $methodName, $defaultArguments))->getResult();
    }

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \Exception('Cannot unserialize a singleton.');
    }
}