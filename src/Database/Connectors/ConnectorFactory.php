<?php

namespace App\Database\Connectors;

use InvalidArgumentException;

class ConnectorFactory
{
    public function createConnector(array $config): ConnectorInterface
    {
        $driver = $config['driver'] ?? null;

        return match ($driver) {
            'mysql' => new MySQLConnector($config),

            default => throw new InvalidArgumentException('Unsupported driver ' . $driver)
        };
    }
}