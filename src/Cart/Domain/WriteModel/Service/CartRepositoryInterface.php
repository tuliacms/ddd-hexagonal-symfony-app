<?php

declare(strict_types=1);

namespace App\Cart\Domain\WriteModel\Service;

use App\Cart\Domain\WriteModel\Model\Cart;
use App\Shared\Domain\WriteModel\Event\AbstractEventSourcingEvent;

/**
 * @author Adam Banaszkiewicz
 */
interface CartRepositoryInterface
{
    public function getNextId(): string;

    public function append(AbstractEventSourcingEvent ...$events): void;

    public function load(string $id): Cart;
}
