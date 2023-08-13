<?php

declare(strict_types=1);

namespace App\Database;

use App\Config\ConfigRepository;
use App\Database\Connectors\ConnectorFactory;
use Exception;

class DatabaseManager
{
    protected array $connections = [];

    public function __construct(
        protected ConnectorFactory $factory,
        protected ConfigRepository $config,
    ) {
    }

    /**
     * @throws Exception
     */
    public function connection(string $name = null): mixed
    {
        $name = $name ?: $this->config->get('database.default_connection');

        if (! isset($this->connections[$name])) {
            $config = $this->getConfiguration($name);

            $this->connections[$name] = $this->factory->createConnector($config)->connect();
        }

        return $this->connections[$name];
    }

    /**
     * @throws Exception
     */
    protected function getConfiguration(string $name): array
    {
        $config = $this->config->get('database.' . $name);

        if (is_null($config)) {
            throw new Exception('The configuration for the connection with the name ' . $name . ' was not found');
        }

        return $config;
    }
}