<?php

declare(strict_types=1);

namespace App\Product\Application\UseCase;

use App\Product\Domain\WriteModel\Exception\ProductDoesNotExistsException;
use App\Product\Domain\WriteModel\Rules\CanICreateNewProduct\CanICreateNewProductInterface;
use App\Product\Domain\WriteModel\Service\ProductRepositoryInterface;

/**
 * @author Adam Banaszkiewicz
 */
final class RemoveProduct
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository,
        private readonly CanICreateNewProductInterface $canICreateNewProduct,
    ) {
    }

    /**
     * @throws ProductDoesNotExistsException
     */
    public function __invoke(string $id): void
    {
        $product = $this->repository->get($id);

        $this->repository->delete($product);
    }
}
