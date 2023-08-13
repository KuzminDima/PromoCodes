<?php

declare(strict_types=1);

namespace App\Response;

class ConsoleResponse implements ResponseInterface
{
    public function __construct(protected string $message)
    {
    }

    public function send(): static
    {
        echo $this->message;

        return $this;
    }
}