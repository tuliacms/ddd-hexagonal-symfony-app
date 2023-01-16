<?php

declare(strict_types=1);

namespace App\Cart\Domain\WriteModel\Model;

use App\Cart\Domain\WriteModel\Event\CartCreated;
use App\Cart\Domain\WriteModel\Event\ProductAddedToCart;
use App\Cart\Domain\WriteModel\Event\ProductQtyIncreased;
use App\Cart\Domain\WriteModel\Event\ProductRemovedFromCart;
use App\Shared\Domain\WriteModel\Event\AbstractEventSourcingEvent;
use Money\Currency;
use Money\Money;

/**
 * @property Product[] $products
 * @author Adam Banaszkiewicz
 */
trait CartRegenerableTrait
{
    /**
     * @param AbstractEventSourcingEvent[] $events
     */
    public static function regenerateFromEvents(array $events): self
    {
        /** @var self $cart */
        $cart = null;

        foreach ($events as $event) {
            switch (get_class($event)) {
                case CartCreated::class:
                    $cart = new self($event->cartId);
                    break;
                case ProductAddedToCart::class:
                    $cart->products[] = new Product(
                        $event->productId,
                        $event->qty,
                        new Money($event->amount, new Currency($event->currency))
                    );
                    break;
                case ProductRemovedFromCart::class:
                    foreach ($cart->products as $key => $product) {
                        if ($product->isA($event->productId)) {
                            unset($cart->products[$key]);
                        }
                    }
                    break;
                case ProductQtyIncreased::class:
                    foreach ($cart->products as $key => $product) {
                        if ($product->isA($event->productId)) {
                            $cart->products[$key] = $product->withQtyOf($product->getQty() + $event->qty);
                        }
                    }
                    break;
            }
        }

        // Reset keys
        $cart->products = array_values($cart->products);

        return $cart;
    }
}
