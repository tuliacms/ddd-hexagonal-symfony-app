<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Event;

/**
 * @author Adam Banaszkiewicz
 */
interface EventBusInterface
{
    public function dispatchCollection(array $events): void;
}
