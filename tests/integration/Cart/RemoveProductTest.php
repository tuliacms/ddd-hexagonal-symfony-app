<?php

declare(strict_types=1);

namespace App\Tests\integration\Cart;

use App\Cart\Application\UseCase\RemoveProduct;
use App\Cart\Domain\WriteModel\Event\ProductRemovedFromCart;
use App\Tests\helper\SymfonyTestCase\Cart\CartEventStore;
use App\Tests\helper\SymfonyTestCase\Cart\CartSeed;
use App\Tests\helper\SymfonyTestCase\Product\ProductSeed;
use App\Tests\integration\AbstractIntegrationTest;

/**
 * @author Adam Banaszkiewicz
 */
final class RemoveProductTest extends AbstractIntegrationTest
{
    private CartEventStore $cartEventStore;
    private CartSeed $cartSeed;
    private ProductSeed $productSeed;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cartEventStore = $this->get(CartEventStore::class);
        $this->cartSeed = $this->get(CartSeed::class);
        $this->productSeed = $this->get(ProductSeed::class);
    }

    public function test_add_product(): void
    {
        // SUT
        /** @var RemoveProduct $removeProduct */
        $removeProduct = $this->get(RemoveProduct::class);

        // Given
        $productId = $this->productSeed->randomProduct('Fallout');
        $cartId = $this->cartSeed->randomCartWithProduct($productId);

        // When
        $removeProduct($cartId, $productId);

        // Then
        self::assertTrue($this->cartEventStore->hasEventOf($cartId, ProductRemovedFromCart::class));
    }
}
