<?php

declare(strict_types=1);

namespace App\Cart\Infrastructure\Persistence\EventStore;

use App\Cart\Domain\WriteModel\Model\Cart;
use App\Cart\Domain\WriteModel\Service\CartRepositoryInterface;
use App\Shared\Domain\WriteModel\Event\AbstractEventSourcingEvent;
use App\Shared\Infrastructure\Persistence\EventStore\EventStore;
use Symfony\Component\Uid\Uuid;

/**
 * @author Adam Banaszkiewicz
 */
final class EventStoreCartRepository implements CartRepositoryInterface
{
    public function __construct(
        private readonly EventStore $eventStore,
    ) {
    }

    public function getNextId(): string
    {
        return (string) Uuid::v4();
    }

    public function append(AbstractEventSourcingEvent ...$events): void
    {
        $this->eventStore->append(...$events);
    }

    public function load(string $id): Cart
    {
        $events = $this->eventStore->load($id);

        return Cart::regenerateFromEvents($events);
    }
}
