<?php

declare(strict_types=1);

namespace App\Handlers\Console;

use App\Database\MySQLMigrator;
use App\Response\ConsoleResponse;
use App\Response\ResponseInterface;

class MigrateDatabaseHandler
{
    public function migrate(MySQLMigrator $migrator): ResponseInterface
    {
        $migrator->migrate();

        return new ConsoleResponse("\e[32mMigration completed successfully.\e[0m\n");
    }
}