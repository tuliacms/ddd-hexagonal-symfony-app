<?php

declare(strict_types=1);

namespace App\Tests\api\Product;

use App\Product\Application\UseCase\CreateProduct;
use App\Tests\api\AbstractApiTestCase;
use App\Tests\helper\SymfonyTestCase\Product\ProductSeed;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Adam Banaszkiewicz
 */
final class DeleteProductTest extends AbstractApiTestCase
{
    private ProductSeed $productSeed;

    protected function setUp(): void
    {
        parent::setUp();

        $this->productSeed = $this->get(ProductSeed::class);
    }

    public function test_delete_product(): void
    {
        // Given
        $id = $this->productSeed->randomProduct('Fallout');

        // When
        $this->request('DELETE', "/api/products/{$id}");

        // Then
        self::assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);
    }

    public function test_expect_404_when_product_not_found(): void
    {
        // When
        $this->request('DELETE', "/api/products/000");

        // Then
        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }
}
