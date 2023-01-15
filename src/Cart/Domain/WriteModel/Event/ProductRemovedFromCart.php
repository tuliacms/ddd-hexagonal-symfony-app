<?php

declare(strict_types=1);

namespace App\Cart\Domain\WriteModel\Event;

use App\Shared\Domain\WriteModel\Event\AbstractEventSourcingEvent;

/**
 * @author Adam Banaszkiewicz
 */
final class ProductRemovedFromCart extends AbstractEventSourcingEvent
{
    public function __construct(
        public readonly string $cartId,
        public readonly string $productId,
    ) {
        parent::__construct();
    }

    public function getAggregateId(): string
    {
        return $this->cartId;
    }
}
