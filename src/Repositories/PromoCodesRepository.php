<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Database\DatabaseManager;
use PDO;

class PromoCodesRepository
{
    protected string $table = 'promo_codes';

    public function __construct(protected DatabaseManager $databaseManager)
    {
    }

    public function findAvailablePromoCode(): ?string
    {
        /** @var PDO $connection */
        $connection = $this->databaseManager->connection();
        $query = $connection->prepare('SELECT code FROM ' . $this->table . ' WHERE issue_date IS NULL LIMIT 1');
        $query->execute();

        $promoCode = $query->fetchColumn();

        return $promoCode ?: null;
    }

    public function findPromoCodeByUserId(string $userId): ?string
    {
        /** @var PDO $connection */
        $connection = $this->databaseManager->connection();
        $query = $connection->prepare('SELECT code FROM ' . $this->table . ' WHERE user_id=:user_id');
        $query->bindParam(':user_id', $userId, PDO::PARAM_STR);
        $query->execute();

        $promoCode = $query->fetchColumn();

        return $promoCode ?: null;
    }

    public function reservePromoCode(string $promoCode, string $userId): bool
    {
        /** @var PDO $connection */
        $connection = $this->databaseManager->connection();
        $query = $connection->prepare('UPDATE ' . $this->table . ' SET issue_date=CURRENT_TIME, user_id=:user_id WHERE code=:code');
        $query->bindParam(':user_id', $userId, PDO::PARAM_STR);
        $query->bindParam(':code', $promoCode, PDO::PARAM_STR);

        return $query->execute();
    }
}