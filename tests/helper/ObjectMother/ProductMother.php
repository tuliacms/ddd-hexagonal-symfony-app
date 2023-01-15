<?php

declare(strict_types=1);

namespace App\Tests\helper\ObjectMother;

use App\Product\Domain\WriteModel\Model\Product;
use App\Tests\helper\TestDoubles\Product\AlwaysTrueCanICreateNewProduct;
use Money\Currency;
use Money\Money;

/**
 * @author Adam Banaszkiewicz
 */
final class ProductMother
{
    private Money $price;

    private function __construct(
        private string $name,
    ) {
    }

    public static function aProduct(string $name): self
    {
        return new self($name);
    }

    public function withPrice(string $amount, string $currency = 'USD'): self
    {
        $this->price = new Money($amount, new Currency($currency));
        return $this;
    }

    public function build(): Product
    {
        $product = Product::create(
            new AlwaysTrueCanICreateNewProduct(),
            $this->name,
            $this->name,
            $this->price,
        );

        $product->collectDomainEvents();

        return $product;
    }
}
