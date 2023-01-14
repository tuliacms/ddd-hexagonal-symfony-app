<?php

declare(strict_types=1);

namespace App\Tests\integration\Product;

use App\Product\Application\UseCase\CreateProduct;
use App\Product\Domain\WriteModel\Exception\CannotCreateNewProductException;
use App\Tests\helper\SymfonyTestCase\Product\ProductSeed;
use App\Tests\helper\SymfonyTestCase\Product\ProductStorage;
use App\Tests\integration\AbstractIntegrationTest;

/**
 * @author Adam Banaszkiewicz
 */
final class CreateProductTest extends AbstractIntegrationTest
{
    private ProductStorage $productStorage;
    private ProductSeed $productSeed;

    protected function setUp(): void
    {
        parent::setUp();

        $this->productStorage = $this->get(ProductStorage::class);
        $this->productSeed = $this->get(ProductSeed::class);
    }

    public function test_create_product(): void
    {
        // SUT
        /** @var CreateProduct $createProduct */
        $createProduct = $this->get(CreateProduct::class);

        // When
        $id = $createProduct('Fallout', 199);

        // Then
        self::assertTrue($this->productStorage->productExists($id));
    }

    public function test_cannot_create_product_with_non_unique_name(): void
    {
        $this->expectException(CannotCreateNewProductException::class);

        // SUT
        /** @var CreateProduct $createProduct */
        $createProduct = $this->get(CreateProduct::class);

        // Given
        $this->productSeed->randomProduct('Fallout');

        // When
        $id = $createProduct('Fallout', 199);

        // Then
        self::assertTrue($this->productStorage->productExists($id));
    }
}
