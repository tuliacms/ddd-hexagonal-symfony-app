<?php

declare(strict_types=1);

namespace App\Cart\Application\UseCase;

use App\Cart\Domain\WriteModel\Exception\CannotAddProductToCartException;
use App\Cart\Domain\WriteModel\Exception\CartDoesNotExistsException;
use App\Cart\Domain\WriteModel\Rules\CanIAddProduct\CanIAddProductInterface;
use App\Cart\Domain\WriteModel\Service\CartRepositoryInterface;
use App\Cart\Domain\WriteModel\Service\ProductFinderInterface;

/**
 * @author Adam Banaszkiewicz
 */
final class AddProduct
{
    public function __construct(
        private readonly CartRepositoryInterface $repository,
        private readonly CanIAddProductInterface $canIAddProduct,
        private readonly ProductFinderInterface $productFinder,
    ) {
    }

    /**
     * @throws CannotAddProductToCartException
     * @throws CartDoesNotExistsException
     */
    public function __invoke(string $cartId, string $productId, int $qty): void
    {
        $cart = $this->repository->load($cartId);
        $cart->addProduct($this->canIAddProduct, $this->productFinder, $productId, $qty);

        $this->repository->append(...$cart->collectDomainEvents());
    }
}
