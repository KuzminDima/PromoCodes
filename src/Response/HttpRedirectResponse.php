<?php

declare(strict_types=1);

namespace App\Response;

use Symfony\Component\HttpFoundation\RedirectResponse as BaseResponse;

class HttpRedirectResponse extends BaseResponse implements ResponseInterface
{
}