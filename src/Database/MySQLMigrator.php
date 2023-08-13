<?php

declare(strict_types=1);

namespace App\Database;

use App\Config\ConfigRepository;
use App\Database\Connectors\MySQLConnector;
use PDO;

class MySQLMigrator
{
    public function __construct(
        protected ConfigRepository $config
    ) {
    }

    public function migrate(): void
    {
        $databaseName = $this->config->get('database.mysql.database');
        $this->config->set('database.mysql.database', null);

        $connector = new MySQLConnector($this->config->get('database.mysql'));
        $connection = $connector->connect();

        $this->config->set('database.mysql.database', $databaseName);

        $this->createDatabase($connection, $databaseName);
        $this->createTables($connection);
    }

    protected function createDatabase(PDO $connection, string $databaseName): void
    {
        $connection->query('CREATE DATABASE IF NOT EXISTS `' . $databaseName . '`  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;');
        $connection->query('use `' . $databaseName . '`');
    }

    public function createTables(PDO $connection): void
    {
        $sql = <<<SQL
            CREATE TABLE IF NOT EXISTS `promo_codes` (
                `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                `code` VARCHAR(10) NULL,
                `issue_date` DATETIME NULL,
                `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `user_id` VARCHAR(255) NULL,
                PRIMARY KEY (`id`),
                UNIQUE INDEX `code_UNIQUE` (`code` ASC),
                UNIQUE INDEX `code_user_id_UNIQUE` (`code` ASC, `user_id` ASC))
             ENGINE = InnoDB
        SQL;

        $connection->query($sql);
    }
}