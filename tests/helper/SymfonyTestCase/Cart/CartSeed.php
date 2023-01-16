<?php

declare(strict_types=1);

namespace App\Tests\helper\SymfonyTestCase\Cart;

use App\Cart\Domain\WriteModel\Model\Cart;
use App\Cart\Domain\WriteModel\Service\CartRepositoryInterface;

/**
 * @author Adam Banaszkiewicz
 */
final class CartSeed
{
    public function __construct(
        private readonly CartRepositoryInterface $repository,
    ) {
    }

    public function randomCart(): string
    {
        $cart = Cart::create($this->repository->getNextId());
        $this->repository->append(...$cart->collectDomainEvents());

        return $cart->getId();
    }
}
