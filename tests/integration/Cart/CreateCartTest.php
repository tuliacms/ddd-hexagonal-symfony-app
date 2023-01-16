<?php

declare(strict_types=1);

namespace App\Tests\integration\Cart;

use App\Cart\Application\UseCase\CreateCart;
use App\Cart\Domain\WriteModel\Event\CartCreated;
use App\Tests\helper\SymfonyTestCase\Cart\CartEventStore;
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
        self::assertTrue($this->cartEventStore->hasEventOf($id, CartCreated::class));
    }
}
