<?php

declare(strict_types=1);

namespace App\Tests\behat\bootstrap\Product\TestDoubles;

use App\Product\Domain\WriteModel\Service\ProductNameDuplicationServiceInterface;

/**
 * @author Adam Banaszkiewicz
 */
final class ProductNameDuplicationServiceStub implements ProductNameDuplicationServiceInterface
{
    private array $duplicates = [];

    public function makeNameDuplicated(string $name): void
    {
        $this->duplicates[$name] = $name;
    }

    public function isNameDuplicated(string $name, string $currentProductId): bool
    {
        return isset($this->duplicates[$name]);
    }
}
