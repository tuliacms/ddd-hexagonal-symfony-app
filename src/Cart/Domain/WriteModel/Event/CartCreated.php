<?php

declare(strict_types=1);

namespace App\Cart\Domain\WriteModel\Event;

/**
 * @author Adam Banaszkiewicz
 */
final class CartCreated extends AbstractEventSourcingEvent
{
    public function __construct(
        public readonly string $id,
    ) {
        parent::__construct();
    }
}
