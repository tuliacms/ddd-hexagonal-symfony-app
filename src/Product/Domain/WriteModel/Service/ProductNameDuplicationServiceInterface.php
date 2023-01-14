<?php

declare(strict_types=1);

namespace App\Product\Domain\WriteModel\Service;

/**
 * @author Adam Banaszkiewicz
 */
interface ProductNameDuplicationServiceInterface
{
    public function isNameDuplicated(string $name, string $currentProductId): bool;
}
