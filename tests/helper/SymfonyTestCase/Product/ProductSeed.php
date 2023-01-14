<?php

declare(strict_types=1);

namespace App\Tests\helper\SymfonyTestCase\Product;

use App\Product\Infrastructure\Filesystem\ProductsStorageFactory;
use App\Tests\helper\ObjectMother\ProductMother;

/**
 * @author Adam Banaszkiewicz
 */
final class ProductSeed
{
    public function __construct(
        private readonly ProductsStorageFactory $factory,
    ) {
    }

    public function randomProduct(string $name): string
    {
        $product = ProductMother::aProduct($name)->withPrice(199)->build();
        $this->factory->storage()->insert($product->toArray());

        return $product->getId();
    }
}
