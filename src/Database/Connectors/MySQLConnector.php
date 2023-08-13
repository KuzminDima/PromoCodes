<?php

declare(strict_types=1);

namespace App\Database\Connectors;

use Exception;
use PDO;

final class MySQLConnector implements ConnectorInterface
{
    public function __construct(private readonly array $config)
    {
    }

    public function connect(): PDO
    {
        [$username, $password, $options] = [
            $this->config['username'] ?? null, $this->config['password'] ?? null, $this->config['options'] ?? []
        ];

        $dsn = $this->getDsn($this->config);

        return new PDO($dsn, $username, $password, $options);
    }

    private function getDSN(array $config): string
    {
        extract($config);

        return "mysql:host={$host};port={$port};dbname={$database}";
    }
}