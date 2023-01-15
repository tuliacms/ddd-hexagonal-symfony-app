<?php

declare(strict_types=1);

namespace App\Cart\Domain\WriteModel\Model;

use Money\Money;

/**
 * @author Adam Banaszkiewicz
 */
final class Product
{
    public function __construct(
        private string $productId,
        private int $qty,
        private Money $price,
    ) {
    }

    public function getPrice(): Money
    {
        return $this->price;
    }

    public function isA(string $productId): bool
    {
        return $this->productId === $productId;
    }

    public function increaseQtyOf(int $qty): void
    {
        $this->qty += $qty;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getQty(): int
    {
        return $this->qty;
    }
}
