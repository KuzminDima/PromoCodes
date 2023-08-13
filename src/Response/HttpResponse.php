<?php

declare(strict_types=1);

namespace App\Response;

use Symfony\Component\HttpFoundation\Response as BaseResponse;
use Exception;

class HttpResponse extends BaseResponse implements ResponseInterface
{
    /**
     * @throws Exception
     */
    public function render(string $viewPath, array $data = []): static
    {
        try {
            ob_start();

            extract($data);
            include $viewPath;

            $render = ob_get_clean();

            $this->setContent($render);
            $this->headers->set('Content-Type', 'text/html; charset=UTF-8');
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        }

        return $this;
    }
}