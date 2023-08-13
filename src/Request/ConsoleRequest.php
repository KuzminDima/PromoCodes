<?php

declare(strict_types=1);

namespace App\Request;

class ConsoleRequest implements RequestInterface
{
    public function __construct(
        protected string $path,
        protected array $arguments
    ) {
    }

    public static function handle(): RequestInterface
    {
        $argv = $argv ?? $_SERVER['argv'] ?? [];

        // remove the script name
        array_shift($argv);

        $path = $argv[0] ?? '';
        $arguments = static::parseArguments(array_slice($argv, 1));

        return new static($path, $arguments);
    }

    protected static function parseArguments(array $arguments): array
    {
        $parsedArguments = [];

        foreach ($arguments as $argument) {
            if (preg_match('/(?:[-]{2})?([^\s^=]+)=(.*)/', $argument,$matches)) {
                $parsedArguments[$matches[1]] = $matches[2];
            }
        }

        return $parsedArguments;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function __get(string $argumentName): mixed
    {
        return $this->arguments[$argumentName] ?? null;
    }
}