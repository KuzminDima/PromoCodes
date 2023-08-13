<?php

use App\Router\Router;
use App\Handlers\Console\MigrateDatabaseHandler;
use App\Handlers\Console\PromoCodesGeneratorHandler;

Router::console('db:migrate', [MigrateDatabaseHandler::class, 'migrate']);
Router::console('db:promo_codes:generate', [PromoCodesGeneratorHandler::class, 'generate']);
