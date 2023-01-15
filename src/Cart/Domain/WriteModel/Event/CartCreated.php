<?php

declare(strict_types=1);

namespace App\Cart\Domain\WriteModel\Event;

use App\Shared\Domain\WriteModel\Event\AbstractDomainEvent;

/**
 * @author Adam Banaszkiewicz
 */
final class CartCreated extends AbstractDomainEvent
{
    public function __construct(
        public readonly string $id,
    ) {
    }
}
