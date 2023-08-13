<?php

declare(strict_types=1);

namespace App\Router\Exceptions;

use Exception;
use Throwable;

class RouteWasNotFound extends Exception
{
    public function __construct(string $message = 'The route was not found', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}