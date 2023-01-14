<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Event;

use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * @author Adam Banaszkiewicz
 */
final class PsrEventDispatcher implements EventBusInterface, EventDispatcherInterface
{
    public function __construct(
        private readonly EventDispatcherInterface $dispatcher,
    ) {
    }

    public function dispatchCollection(array $events): void
    {
        foreach ($events as $event) {
            $this->dispatch($event);
        }
    }

    public function dispatch(object $event): void
    {
        $this->dispatcher->dispatch($event);
    }
}
