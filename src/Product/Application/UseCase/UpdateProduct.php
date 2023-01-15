<?php

declare(strict_types=1);

namespace App\Product\Application\UseCase;

use App\Product\Domain\WriteModel\Exception\CannotRenameProductException;
use App\Product\Domain\WriteModel\Exception\ProductDoesNotExistsException;
use App\Product\Domain\WriteModel\Rules\CanIRenameProduct\CanIRenameProductInterface;
use App\Product\Domain\WriteModel\Service\ProductRepositoryInterface;
use App\Shared\Infrastructure\Bus\Event\EventBusInterface;

/**
 * @author Adam Banaszkiewicz
 */
final class UpdateProduct
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository,
        private readonly EventBusInterface $eventBus,
        private readonly CanIRenameProductInterface $canIRenameProduct,
    ) {
    }

    /**
     * @throws ProductDoesNotExistsException
     * @throws CannotRenameProductException
     */
    public function __invoke(string $id, ?string $name, ?string $price): void
    {
        $product = $this->repository->get($id);

        if ($name) {
            $product->rename($this->canIRenameProduct, $name);
        }
        if ($price) {
            $product->changePrice($price);
        }

        $this->repository->save($product);
        $this->eventBus->dispatchCollection($product->collectDomainEvents());
    }
}
