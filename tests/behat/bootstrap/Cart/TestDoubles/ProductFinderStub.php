<?php

declare(strict_types=1);

namespace App\Tests\behat\bootstrap\Cart\TestDoubles;

use App\Cart\Domain\WriteModel\Model\Product;
use App\Cart\Domain\WriteModel\Service\ProductFinderInterface;
use Money\Currency;
use Money\Money;

/**
 * @author Adam Banaszkiewicz
 */
final class ProductFinderStub implements ProductFinderInterface
{
    private array $products = [];

    public function makeProductExists(string $product, string $amount, string $currency): void
    {
        $this->products[$product] = [
            'amount' => $amount,
            'currency' => $currency,
        ];
    }

    public function find(string $id): ?Product
    {
        if (!isset($this->products[$id])) {
            return null;
        }

        return new Product($id, 0, new Money((string) $this->products[$id]['amount'], new Currency($this->products[$id]['currency'])));
    }
}
