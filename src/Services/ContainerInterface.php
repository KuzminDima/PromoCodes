<?php

declare(strict_types=1);

namespace App\Services;

interface ContainerInterface
{
    public function get(string $id): object|string|null;
    public function has(string $id): bool;
}