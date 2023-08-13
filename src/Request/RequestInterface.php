<?php

declare(strict_types=1);

namespace App\Request;

interface RequestInterface
{
    public static function handle(): RequestInterface;
    public function getPath(): string;
}
