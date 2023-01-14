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
final class CreateProductTest extends AbstractApiTestCase
{
    private ProductSeed $productSeed;

    protected function setUp(): void
    {
        parent::setUp();

        $this->productSeed = $this->get(ProductSeed::class);
    }

    public function test_create_product(): void
    {
        // When
        $this->request('POST', '/api/products', [
            'name' => 'Fallout',
            'price' => 199,
        ]);

        // Then
        self::assertResponseStatusCodeSame(Response::HTTP_CREATED);
        self::assertResponseHasIdField();
    }
}
