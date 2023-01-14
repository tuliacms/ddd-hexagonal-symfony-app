<?php

declare(strict_types=1);

namespace App\Tests\api\Product;

use App\Tests\api\AbstractApiTestCase;
use App\Tests\helper\SymfonyTestCase\Product\ProductSeed;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Adam Banaszkiewicz
 */
final class PatchProductTest extends AbstractApiTestCase
{
    private ProductSeed $productSeed;

    protected function setUp(): void
    {
        parent::setUp();

        $this->productSeed = $this->get(ProductSeed::class);
    }

    public function test_full_patch_product(): void
    {
        // Given
        $id = $this->productSeed->randomProduct('Fallout');

        // When
        $this->request('PATCH', "/api/products/{$id}", [
            'name' => 'Fallout 76',
            'price' => 299,
        ]);

        // Then
        self::assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);
    }

    public function test_null_patch_product(): void
    {
        // Given
        $id = $this->productSeed->randomProduct('Fallout');

        // When
        $this->request('PATCH', "/api/products/{$id}");

        // Then
        self::assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);
    }
}
