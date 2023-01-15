<?php

declare(strict_types=1);

namespace App\Tests\helper\SymfonyTestCase\Cart;

use App\Shared\Infrastructure\Persistence\EventStore\EventStore;

/**
 * @author Adam Banaszkiewicz
 */
final class CartEventStore
{
    public function __construct(
        private readonly EventStore $eventStore,
    ) {
    }

    public function countEventsOf(string $aggregateId): int
    {
        return \count($this->eventStore->load($aggregateId));
    }
}
