<?php

declare(strict_types=1);

namespace App\Request;

use Symfony\Component\HttpFoundation\Request;

class HttpRequest extends Request implements RequestInterface
{
    public static function handle(): RequestInterface
    {
        return static::createFromGlobals();
    }

    public function getPath(): string
    {
        return $this->getRequestUri();
    }
}