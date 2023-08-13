<?php

declare(strict_types=1);

namespace App\Config;

use App\Accessors\Arrays\AccessorArrayInterface;

class ConfigRepository
{
    public function __construct(
        protected array $config,
        protected AccessorArrayInterface $accessor
    ) {
    }

    public function get(string $key): mixed
    {
        return $this->accessor->get($key, $this->config);
    }

    public function set(string $key, mixed $value): array
    {
        return $this->accessor->set($key, $value, $this->config);
    }
}
