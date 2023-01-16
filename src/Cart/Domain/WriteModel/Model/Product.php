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

    public function toArray(): array
    {
        $sumPrice = $this->getPrice()->multiply($this->getQty());

        return [
            'product_id' => $this->productId,
            'qty' => $this->qty,
            'total_price' => [
                'amount' => $sumPrice->getAmount(),
                'currency' => $sumPrice->getCurrency()->getCode(),
            ],
            'singular_price' => [
                'amount' => $this->price->getAmount(),
                'currency' => $this->price->getCurrency()->getCode(),
            ],
        ];
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

    public function withQtyOf(int $qty): self
    {
        $self = clone $this;
        $self->qty = $qty;

        return $self;
    }
}
