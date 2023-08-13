<?php

return [
    'database' => [
        'default_connection' => 'mysql',
        'mysql' => [
            'driver' => 'mysql',
            'host' => $_ENV['MYSQL_HOST'],
            'port' => $_ENV['MYSQL_PORT'],
            'database' => $_ENV['MYSQL_DATABASE'],
            'username' => $_ENV['MYSQL_USERNAME'],
            'password' => $_ENV['MYSQL_PASSWORD'],
            'options' => [],
        ],
    ],
    'views' => [
        'path' => __DIR__ . '/src/Views',
    ]
];
