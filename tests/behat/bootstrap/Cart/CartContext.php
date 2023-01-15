<?php

namespace App\Tests\behat\bootstrap\Cart;

use App\Cart\Domain\WriteModel\Event\CartCreated;
use App\Cart\Domain\WriteModel\Event\ProductAddedToCart;
use App\Cart\Domain\WriteModel\Event\ProductQtyIncreased;
use App\Cart\Domain\WriteModel\Event\ProductRemovedFromCart;
use App\Cart\Domain\WriteModel\Exception\CannotAddProductToCartException;
use App\Cart\Domain\WriteModel\Model\Cart;
use App\Cart\Domain\WriteModel\Rules\CanIAddProduct\CanIAddProduct;
use App\Cart\Domain\WriteModel\Service\ProductFinderInterface;
use App\Tests\behat\bootstrap\AggregateRootSpy;
use App\Tests\behat\bootstrap\Assert;
use App\Tests\behat\bootstrap\Cart\TestDoubles\ProductFinderStub;
use Behat\Behat\Context\Context;

/**
 * Defines application features from the specific context.
 */
class CartContext implements Context
{
    use CartBuildableTrait;

    private ProductFinderInterface $productFinder;
    private ?string $reasonWhyCannotAddNewProduct = null;

    public function __construct()
    {
        $this->productFinder = new ProductFinderStub();
    }

    /**
     * @When I create new cart
     */
    public function iCreateNewCart(): void
    {
        $this->cart = Cart::create('de49a794-20bb-4598-9620-ceb7d72e5b41');
        $this->cartSpy = new AggregateRootSpy($this->cart);
    }

    /**
     * @Then new cart should be created
     */
    public function newCartShouldBeCreated(): void
    {
        $event = $this->cartSpy->findEvent(CartCreated::class);

        Assert::assertInstanceOf(CartCreated::class, $event, 'Cart should be created');
    }

    /**
     * @Given there is product named :product, with price :amount :currency
     */
    public function thereIsProductNamedWithPriceUsd(string $product, string $amount, string $currency): void
    {
        $this->productFinder->makeProductExists($product, $amount, $currency);
    }

    /**
     * @When I add product :product to cart, with qty of :qty
     */
    public function iAddProductToCartWithQtyOf(string $product, int $qty): void
    {
        try {
            $this->cart->addProduct(
                new CanIAddProduct(),
                $this->productFinder,
                $product,
                $qty
            );
        } catch (CannotAddProductToCartException $e) {
            $this->reasonWhyCannotAddNewProduct = $e->reason;
        }
    }

    /**
     * @Then new product should be added to cart
     */
    public function newProductShouldBeAddedToCart(): void
    {
        $event = $this->cartSpy->findEvent(ProductAddedToCart::class);

        Assert::assertInstanceOf(ProductAddedToCart::class, $event, 'Product should be added to cart');
    }

    /**
     * @Then product qty should be increased by :qty
     */
    public function productQtyShouldBeIncreasedBy(int $qty): void
    {
        /** @var ProductQtyIncreased $event */
        $event = $this->cartSpy->findEvent(ProductQtyIncreased::class);

        Assert::assertInstanceOf(ProductQtyIncreased::class, $event, 'Product qty should be increased');
        Assert::assertSame($qty, $event->qty);
    }

    /**
     * @Then product qty should not be increased, because :reason
     */
    public function productQtyShouldNotBeIncreasedBecause(string $reason): void
    {
        Assert::assertSame($reason, $this->reasonWhyCannotAddNewProduct);
    }

    /**
     * @Then new product should not be added to cart, because :reason
     */
    public function newProductShouldNotBeAddedToCartBecause(string $reason): void
    {
        Assert::assertSame($reason, $this->reasonWhyCannotAddNewProduct);
    }

    /**
     * @When I remove product :product from cart
     */
    public function iRemoveProductFromCart(string $product): void
    {
        $this->cart->removeProduct($product);
    }

    /**
     * @Then product :product should be removed from cart
     */
    public function productShouldBeRemovedFromCart(string $product): void
    {
        /** @var ProductRemovedFromCart $event */
        $event = $this->cartSpy->findEvent(ProductRemovedFromCart::class);

        Assert::assertInstanceOf(ProductRemovedFromCart::class, $event, 'Product should be removed from cart');
        Assert::assertSame($product, $event->productId);
    }

    /**
     * @Then no product should be removed from cart
     */
    public function noProductShouldBeRemovedFromCart(): void
    {
        $event = $this->cartSpy->findEvent(ProductRemovedFromCart::class);

        Assert::assertNull($event, 'No product should be removed from cart');
    }
}
