<?php

declare(strict_types=1);

namespace App\Cart\Infrastructure\Persistence\EventStore;

use App\Cart\Domain\ReadModel\Query\CartFinderInterface;
use App\Cart\Domain\WriteModel\Exception\CartDoesNotExistsException;

/**
 * @author Adam Banaszkiewicz
 */
final class RepositoryCartFinder implements CartFinderInterface
{
    public function __construct(
        private readonly EventStoreCartRepository $repository,
    ) {
    }

    public function find(string $id): ?array
    {
        try {
            return $this->repository->load($id)->toArray();
        } catch (CartDoesNotExistsException $e) {
            return null;
        }
    }
}
