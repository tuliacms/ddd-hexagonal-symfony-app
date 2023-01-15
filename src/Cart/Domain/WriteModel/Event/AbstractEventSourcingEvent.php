<?php

declare(strict_types=1);

namespace App\Cart\Domain\WriteModel\Event;

use DateTimeImmutable;
use App\Shared\Domain\WriteModel\Event\AbstractDomainEvent;

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
}
