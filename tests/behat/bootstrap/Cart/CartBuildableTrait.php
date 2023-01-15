<?php

declare(strict_types=1);

namespace App\Tests\behat\bootstrap\Cart;

use App\Cart\Domain\WriteModel\Model\Cart;
use App\Cart\Domain\WriteModel\Service\ProductFinderInterface;
use App\Tests\behat\bootstrap\AggregateRootSpy;
use App\Tests\helper\ObjectMother\CartMother;

/**
 * @author Adam Banaszkiewicz
 * @property Cart $cart
 * @property AggregateRootSpy $cartSpy
 * @property ProductFinderInterface $productFinder
 */
trait CartBuildableTrait
{
    private CartMother $cartMother;

    public function __get(string $name)
    {
        if ($name !== 'cart') {
            throw new \LogicException(sprintf('You can get only Cart through magic getter, "%s" called.', $name));
        }

        if (false === property_exists($this, 'cart')) {
            $this->cart = $this->cartMother->build($this->productFinder);
            $this->cartSpy = new AggregateRootSpy($this->cart);
        }

        return $this->cart;
    }

    /**
     * @Given there is a cart
     */
    public function thereIsACart(): void
    {
        $this->cartMother = CartMother::aCart();
    }

    /**
     * @Given there is a :product product in cart, with qty of :qty
     */
    public function thereIsAProductInCartWithQtyOf(string $product, int $qty): void
    {
        $this->cartMother->withProduct($product, $qty);
    }
}
