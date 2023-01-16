<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\EventStore;

use App\Shared\Domain\WriteModel\Event\AbstractEventSourcingEvent;
use App\Shared\Infrastructure\Persistence\Filesystem\SleekStorage;
use Symfony\Component\Uid\Uuid;

/**
 * @author Adam Banaszkiewicz
 */
final class EventStore
{
    public function __construct(
        private readonly SleekStorage $storage,
    ) {
    }

    public function append(AbstractEventSourcingEvent ...$events): void
    {
        $store = $this->storage->store('event_store');

        foreach ($events as $event) {
            $store->insert([
                'event_id' => (string) Uuid::v4(),
                'event_type' => get_class($event),
                'event_date' => $event->createdAt->format('Y-m-d H:i:s'),
                'aggregate_id' => $event->getAggregateId(),
                'serialized_event' => serialize($event),
            ]);
        }
    }

    /**
     * @return AbstractEventSourcingEvent[]
     */
    public function load(string $id): array
    {
        $store = $this->storage->store('event_store');
        $raw = $store->findBy(['aggregate_id', '=', $id]);
        $events = [];

        usort($raw, fn($a, $b) => $a['event_date'] <=> $b['event_date']);

        foreach ($raw as $row) {
            $events[] = unserialize($row['serialized_event']);
        }

        return $events;
    }
}
