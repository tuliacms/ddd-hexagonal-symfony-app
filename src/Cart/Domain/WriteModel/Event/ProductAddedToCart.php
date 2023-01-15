<?php

declare(strict_types=1);

namespace App\Cart\Domain\WriteModel\Event;

/**
 * @author Adam Banaszkiewicz
 */
final class ProductAddedToCart extends AbstractEventSourcingEvent
{
    public function __construct(
        public readonly string $cartId,
        public readonly string $productId,
        public readonly int $qty,
        public readonly string $amount,
        public readonly string $currency,
    ) {
        parent::__construct();
    }
}
