<?php

declare(strict_types=1);

namespace App\Shared\Domain\WriteModel\Event;

use DateTimeImmutable;

/**
 * @author Adam Banaszkiewicz
 */
abstract class AbstractEventSourcingEvent extends AbstractDomainEvent
{
    public readonly DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
    }

    abstract public function getAggregateId(): string;
}
