<?php

declare(strict_types=1);

namespace App\Handlers\Web;

use App\Config\ConfigRepository;
use App\Repositories\PromoCodesRepository;
use App\Response\HttpRedirectResponse;
use App\Response\HttpResponse;
use Symfony\Component\HttpFoundation\Session\Session;

class PromoCodeHandler
{
    public function showPromoCodeForm(ConfigRepository $config, Session $session): HttpResponse
    {
        return (new HttpResponse())
            ->render($config->get('views.path') . '/promo-code-form.php', ['session' => $session]);
    }

    public function retrievePromoCode(
        Session $session,
        PromoCodesRepository $promoCodesRepository
    ): HttpRedirectResponse {
        $promoCode = $session->has('promoCode')
            ? $session->get('promoCode')
            : $promoCodesRepository->findPromoCodeByUserId($session->getId());

        if ($promoCode) {
            return new HttpRedirectResponse('https://www.google.com/?query=' . $promoCode);
        }

        $promoCode = $promoCodesRepository->findAvailablePromoCode();

        if (is_null($promoCode)) {
            $session->getFlashBag()->add('warning', 'Available promo codes are over');

            return new HttpRedirectResponse('/');
        }

        $promoCodesRepository->reservePromoCode($promoCode, $session->getId());
        $session->set('promoCode', $promoCode);

        return new HttpRedirectResponse('https://www.google.com/?query=' . $promoCode);
    }
}