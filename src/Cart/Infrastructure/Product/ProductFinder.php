<?php

declare(strict_types=1);

namespace App\Cart\Infrastructure\Product;

use App\Cart\Domain\WriteModel\Model\Product;
use App\Cart\Domain\WriteModel\Service\ProductFinderInterface;
use App\Product\UserInterface\OpenHost\Query\ProductService;
use Money\Currency;
use Money\Money;

/**
 * @author Adam Banaszkiewicz
 */
final class ProductFinder implements ProductFinderInterface
{
    public function __construct(
        private readonly ProductService $productService,
    ) {
    }

    public function find(string $id): ?Product
    {
        $product = $this->productService->findProduct($id);

        if (!$product) {
            return null;
        }

        return new Product(
            $id,
            0,
            new Money($product['price']['amount'], new Currency($product['price']['currency']))
        );
    }
}
