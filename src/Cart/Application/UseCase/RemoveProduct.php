<?php

declare(strict_types=1);

namespace App\Cart\Application\UseCase;

use App\Cart\Domain\WriteModel\Exception\CartDoesNotExistsException;
use App\Cart\Domain\WriteModel\Service\CartRepositoryInterface;

/**
 * @author Adam Banaszkiewicz
 */
final class RemoveProduct
{
    public function __construct(
        private readonly CartRepositoryInterface $repository,
    ) {
    }

    /**
     * @throws CartDoesNotExistsException
     */
    public function __invoke(string $cartId, string $productId): void
    {
        $cart = $this->repository->load($cartId);
        $cart->removeProduct($productId);

        $this->repository->append(...$cart->collectDomainEvents());
    }
}
