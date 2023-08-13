<?php

declare(strict_types=1);

namespace App\Accessors\Arrays;

interface AccessorArrayInterface
{
    public function get(string $key, array $array): mixed;
    public function set(string $key, mixed $value, array &$array): array;
}
