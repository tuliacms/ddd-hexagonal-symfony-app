<?php

declare(strict_types=1);

namespace App\Tests\helper\SymfonyTestCase\Cart;

use App\Cart\Domain\WriteModel\Model\Cart;
use App\Cart\Domain\WriteModel\Service\CartRepositoryInterface;
use App\Cart\Domain\WriteModel\Service\ProductFinderInterface;
use App\Tests\behat\bootstrap\Cart\TestDoubles\AlwaysTrueCanIAddProduct;

/**
 * @author Adam Banaszkiewicz
 */
final class CartSeed
{
    public function __construct(
        private readonly CartRepositoryInterface $repository,
        private readonly ProductFinderInterface $finder,
    ) {
    }

    public function randomCart(): string
    {
        $cart = Cart::create($this->repository->getNextId());
        $this->repository->append(...$cart->collectDomainEvents());

        return $cart->getId();
    }

    public function randomCartWithProduct(string $productId): string
    {
        $cart = Cart::create($this->repository->getNextId());
        $cart->addProduct(new AlwaysTrueCanIAddProduct(), $this->finder, $productId, 1);
        $this->repository->append(...$cart->collectDomainEvents());

        return $cart->getId();
    }
}
