<?php

declare(strict_types=1);

namespace App\Response;

interface ResponseInterface
{
    public function send(): static;
}
