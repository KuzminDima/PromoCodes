<?php

declare(strict_types=1);

namespace App\Database\Connectors;

interface ConnectorInterface
{
    public function connect();
}
