<?php

$config = require_once __DIR__ . '/config.php';

use App\Accessors\Arrays\DotNotationArrayAccessor;
use App\Config\ConfigRepository;
use App\Database\Connectors\ConnectorFactory;
use App\Database\DatabaseManager;
use App\Router\Router;
use App\Services\Container;

$bindings = [
    ConfigRepository::class => new ConfigRepository($config, new DotNotationArrayAccessor),
    ConnectorFactory::class => ConnectorFactory::class,
    DatabaseManager::class => DatabaseManager::class,
    Router::class => Router::class,
];

$serviceContainer = Container::getInstance();

foreach ($bindings as $id => $binding) {
    $serviceContainer->bind($id, $binding);
}

return $serviceContainer;