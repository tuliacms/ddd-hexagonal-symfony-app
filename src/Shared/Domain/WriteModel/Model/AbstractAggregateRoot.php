<?php

declare(strict_types=1);

namespace App\Shared\Domain\WriteModel\Model;

use App\Shared\Domain\WriteModel\Event\AbstractDomainEvent;

/**
 * @author Adam Banaszkiewicz
 */
abstract class AbstractAggregateRoot
{
    /**
     * @var AbstractDomainEvent[]
     */
    private array $events = [];

    protected function recordThat(AbstractDomainEvent $event): void
    {
        $this->events[] = $event;
    }

    /**
     * @return AbstractDomainEvent[]
     */
    public function collectDomainEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }
}
