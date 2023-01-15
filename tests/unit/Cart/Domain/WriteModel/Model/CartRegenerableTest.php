<?php

declare(strict_types=1);

namespace App\Tests\unit\Cart\Domain\WriteModel\Model;

use App\Cart\Domain\WriteModel\Event\CartCreated;
use App\Cart\Domain\WriteModel\Event\ProductAddedToCart;
use App\Cart\Domain\WriteModel\Event\ProductQtyIncreased;
use App\Cart\Domain\WriteModel\Event\ProductRemovedFromCart;
use App\Cart\Domain\WriteModel\Model\Cart;
use App\Tests\unit\AbstractUnitTestCase;

/**
 * @author Adam Banaszkiewicz
 */
final class CartRegenerableTest extends AbstractUnitTestCase
{
    private const CART_ID = 'a37a0c28-7c68-46ab-9f6e-2d0bc6c003cc';

    public function test_regenerable_cart(): void
    {
        // When
        $cart = Cart::regenerateFromEvents([
            new CartCreated(self::CART_ID),
            new ProductAddedToCart(self::CART_ID, 'Fallout', 1, '199', 'USD'),
            new ProductAddedToCart(self::CART_ID, 'Don’t Starve', 3, '299', 'USD'),
            new ProductRemovedFromCart(self::CART_ID, 'Fallout'),
            new ProductQtyIncreased(self::CART_ID, 'Don’t Starve', 7),
        ]);

        //Then
        self::assertSame([
            'id' => self::CART_ID,
            'products' => [
                [
                    'product_id' => 'Don’t Starve',
                    'qty' => 10,
                    'price' => [
                        'amount' => '299',
                        'currency' => 'USD',
                    ],
                ],
            ],
        ], $cart->toArray());
    }
}
