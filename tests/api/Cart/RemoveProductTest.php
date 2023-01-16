<?php

declare(strict_types=1);

namespace App\Tests\api\Cart;

use App\Tests\api\AbstractApiTestCase;
use App\Tests\helper\SymfonyTestCase\Cart\CartSeed;
use App\Tests\helper\SymfonyTestCase\Product\ProductSeed;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Adam Banaszkiewicz
 */
final class RemoveProductTest extends AbstractApiTestCase
{
    private CartSeed $cartSeed;
    private ProductSeed $productSeed;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cartSeed = $this->get(CartSeed::class);
        $this->productSeed = $this->get(ProductSeed::class);
    }

    public function test_add_product_to_cart(): void
    {
        // Given
        $productId = $this->productSeed->randomProduct('Fallout');
        $cartId = $this->cartSeed->randomCartWithProduct($productId);

        // When
        $this->request('DELETE', "/api/carts/{$cartId}/products/{$productId}");

        // Then
        self::assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);
    }
}
