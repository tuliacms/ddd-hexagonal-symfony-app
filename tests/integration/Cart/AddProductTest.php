<?php

declare(strict_types=1);

namespace App\Tests\integration\Cart;

use App\Cart\Application\UseCase\AddProduct;
use App\Cart\Application\UseCase\CreateCart;
use App\Cart\Domain\WriteModel\Event\ProductAddedToCart;
use App\Cart\Domain\WriteModel\Event\ProductQtyIncreased;
use App\Cart\Domain\WriteModel\Service\CartRepositoryInterface;
use App\Tests\helper\SymfonyTestCase\Cart\CartEventStore;
use App\Tests\helper\SymfonyTestCase\Cart\CartSeed;
use App\Tests\helper\SymfonyTestCase\Product\ProductSeed;
use App\Tests\integration\AbstractIntegrationTest;

/**
 * @author Adam Banaszkiewicz
 */
final class AddProductTest extends AbstractIntegrationTest
{
    private CartEventStore $cartEventStore;
    private CartSeed $cartSeed;
    private CartRepositoryInterface $cartRepository;
    private ProductSeed $productSeed;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cartEventStore = $this->get(CartEventStore::class);
        $this->cartSeed = $this->get(CartSeed::class);
        $this->productSeed = $this->get(ProductSeed::class);
        $this->cartRepository = $this->get(CartRepositoryInterface::class);
    }

    public function test_add_product(): void
    {
        // SUT
        /** @var AddProduct $addProduct */
        $addProduct = $this->get(AddProduct::class);

        // Given
        $cartId = $this->cartSeed->randomCart();
        $productId = $this->productSeed->randomProduct('Fallout');

        // When
        $addProduct($cartId, $productId, 3);

        // Then
        self::assertTrue($this->cartEventStore->hasEventOf($cartId, ProductAddedToCart::class));
    }

    public function test_add_same_product_multiple_times(): void
    {
        // SUT
        /** @var AddProduct $addProduct */
        $addProduct = $this->get(AddProduct::class);

        // Given
        $cartId = $this->cartSeed->randomCart();
        $productId = $this->productSeed->randomProduct('Fallout');

        // When
        $addProduct($cartId, $productId, 1);
        $addProduct($cartId, $productId, 3);

        // Then
        self::assertTrue($this->cartEventStore->hasEventOf($cartId, ProductAddedToCart::class));
        self::assertTrue($this->cartEventStore->hasEventOf($cartId, ProductQtyIncreased::class));

        $cart = $this->cartRepository->load($cartId)->toArray();
        self::assertSame(1, count($cart['products']));
        self::assertSame(4, $cart['products'][0]['qty']);
    }
}
