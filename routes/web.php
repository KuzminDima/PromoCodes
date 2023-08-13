<?php

use App\Handlers\Web\PromoCodeHandler;
use App\Router\Router;

Router::web('GET', '/', [PromoCodeHandler::class, 'showPromoCodeForm']);
Router::web('POST', '/retrieve-promo-code', [PromoCodeHandler::class, 'retrievePromoCode']);
