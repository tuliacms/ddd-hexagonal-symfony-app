<?php

declare(strict_types=1);

namespace App\Product\Domain\WriteModel\Event;

use App\Shared\Domain\WriteModel\Event\AbstractDomainEvent;

/**
 * @author Adam Banaszkiewicz
 */
final class ProductCreated extends AbstractDomainEvent
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly float $amount,
        public readonly string $currrency,
    ) {
    }
}
