<?php

declare(strict_types=1);

namespace App\Tests\integration\Cart;

use App\Cart\Application\UseCase\CreateCart;
use App\Product\Application\UseCase\CreateProduct;
use App\Tests\helper\SymfonyTestCase\Cart\CartEventStore;
use App\Tests\helper\SymfonyTestCase\Product\ProductSeed;
use App\Tests\helper\SymfonyTestCase\Product\ProductStorage;
use App\Tests\integration\AbstractIntegrationTest;

/**
 * @author Adam Banaszkiewicz
 */
final class CreateCartTest extends AbstractIntegrationTest
{
    private CartEventStore $cartEventStore;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cartEventStore = $this->get(CartEventStore::class);
    }

    public function test_create_product(): void
    {
        // SUT
        /** @var CreateCart $createCart */
        $createCart = $this->get(CreateCart::class);

        // When
        $id = $createCart();

        // Then
        self::assertSame(1, $this->cartEventStore->countEventsOf($id));
    }
}
