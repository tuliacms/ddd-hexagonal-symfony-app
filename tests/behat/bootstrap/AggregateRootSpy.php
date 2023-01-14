<?php

declare(strict_types=1);

namespace App\Tests\behat\bootstrap;

use App\Shared\Domain\WriteModel\Model\AbstractAggregateRoot;
use App\Shared\Domain\WriteModel\Event\AbstractDomainEvent;

/**
 * @author Adam Banaszkiewicz
 */
final class AggregateRootSpy
{
    /** @var AbstractDomainEvent[][] */
    private array $aggregateEventsCollection = [];

    public function __construct(
        private ?AbstractAggregateRoot $aggregate,
    ) {
    }

    /**
     * @return AbstractDomainEvent[]
     */
    public function collectEvents(): array
    {
        if ($this->aggregate === null) {
            return [];
        }

        if (isset($this->aggregateEventsCollection[spl_object_id($this->aggregate)])) {
            return $this->aggregateEventsCollection[spl_object_id($this->aggregate)];
        }

        return $this->aggregateEventsCollection[spl_object_id($this->aggregate)]
            = $this->aggregate->collectDomainEvents();
    }

    public function findEvent(string $classname): ?AbstractDomainEvent
    {
        foreach ($this->collectEvents() as $event) {
            if ($event instanceof $classname) {
                return $event;
            }
        }

        return null;
    }
}
