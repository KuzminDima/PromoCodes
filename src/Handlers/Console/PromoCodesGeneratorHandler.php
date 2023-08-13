<?php

declare(strict_types=1);

namespace App\Handlers\Console;

use App\Database\DatabaseManager;
use App\Request\ConsoleRequest;
use App\Response\ConsoleResponse;
use App\Response\ResponseInterface;
use Exception;
use PDO;

class PromoCodesGeneratorHandler
{
    protected const MAX_ALLOWED_PACKET_SIZE = 15000;
    protected array $generatedPromoCodes = [];

    public function generate(ConsoleRequest $request, DatabaseManager $databaseManager): ResponseInterface
    {
        $size = (int) $request->size ?? 500000;

        /** @var PDO $connection */
        $connection = $databaseManager->connection('mysql');
        $connection->setAttribute(PDO::ATTR_AUTOCOMMIT,0);
        $connection->exec('TRUNCATE TABLE promo_codes');

        try {
            $connection->beginTransaction();

            $values = '';
            for ($i = 0; $i < $size; $i++) {
                $values .= '(\'' . $this->generateRandomPromoCode() . '\'),';

                if ($i > 0 && $i % static::MAX_ALLOWED_PACKET_SIZE === 0) {
                    $this->insertPromoCodePacket($connection, rtrim($values, ',') . ';');
                    $values = '';
                }
            }

            if ($values) {
                $this->insertPromoCodePacket($connection, rtrim($values, ',') . ';');
            }

            $connection->commit();
        } catch (Exception $e) {
            $connection->rollBack();

            throw $e;
        } finally {
            $connection->setAttribute(PDO::ATTR_AUTOCOMMIT,1);
        }

        return new ConsoleResponse("\e[32m" . $size . " promo codes have been successfully generated.\e[0m\n");
    }

    protected function insertPromoCodePacket(PDO $connection, string $values): void
    {
        $connection->exec('INSERT promo_codes (code) VALUES ' . $values);
    }

    protected function generateRandomPromoCode(): string
    {
        $promoCode = bin2hex(random_bytes(5));

        if (isset($this->generatedPromoCodes[$promoCode])) {
            return $this->generateRandomPromoCode();
        }

        $this->generatedPromoCodes[$promoCode] = true;

        return $promoCode;
    }
}