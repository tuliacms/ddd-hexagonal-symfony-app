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
final class AddProductTest extends AbstractApiTestCase
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
        $cartId = $this->cartSeed->randomCart();
        $productId = $this->productSeed->randomProduct('Fallout');

        // When
        $this->request('POST', "/api/carts/{$cartId}/products", [
            'id' => $productId,
            'qty' => 1,
        ]);

        // Then
        self::assertResponseStatusCodeSame(Response::HTTP_CREATED);
    }
}
