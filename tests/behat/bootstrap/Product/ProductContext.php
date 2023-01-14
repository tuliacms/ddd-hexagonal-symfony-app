<?php

namespace App\Tests\behat\bootstrap\Product;

use App\Product\Domain\WriteModel\Event\ProductCreated;
use App\Product\Domain\WriteModel\Event\ProductRenamed;
use App\Product\Domain\WriteModel\Exception\CannotCreateNewProductException;
use App\Product\Domain\WriteModel\Exception\CannotRenameProductException;
use App\Product\Domain\WriteModel\Model\Product;
use App\Product\Domain\WriteModel\Rules\CanICreateNewProduct\CanICreateNewProduct;
use App\Product\Domain\WriteModel\Rules\CanIRenameProduct\CanIRenameProduct;
use App\Product\Domain\WriteModel\Service\ProductNameDuplicationServiceInterface;
use App\Tests\behat\bootstrap\AggregateRootSpy;
use App\Tests\behat\bootstrap\Assert;
use App\Tests\behat\bootstrap\Product\TestDoubles\ProductNameDuplicationServiceStub;
use App\Tests\helper\ObjectMother\ProductMother;
use Behat\Behat\Context\Context;
use Money\Currency;
use Money\Money;

/**
 * Defines application features from the specific context.
 */
class ProductContext implements Context
{
    private Product $product;
    private AggregateRootSpy $productSpy;
    private ProductNameDuplicationServiceInterface $productNameDuplicationService;
    private ?string $reasonWhyNewProductCannotBeCreated = null;
    private ?string $reasonWhyProductCannotBeRenamed = null;

    public function __construct()
    {
        $this->productNameDuplicationService = new ProductNameDuplicationServiceStub();
    }

    /**
     * @Given there is product named :product, with price :amount :currency
     */
    public function thereIsProductNamedWithPriceUsd(string $product, float $amount, string $currency): void
    {
        $this->product = ProductMother::aProduct($product)->withPrice($amount, $currency)->build();
        $this->productSpy = new AggregateRootSpy($this->product);
    }

    /**
     * @Given there is some product in system named :product
     */
    public function thereIsSomeProductInSystemNamed(string $product): void
    {
        $this->productNameDuplicationService->makeNameDuplicated($product);
    }

    /**
     * @When I create new product named :product, with price :amount :currency
     */
    public function iCreateNewProductNamedWithPrice(string $product, float $amount, string $currency): void
    {
        try {
            $this->product = Product::create(
                new CanICreateNewProduct($this->productNameDuplicationService),
                $product,
                $product,
                new Money($amount, new Currency($currency))
            );
            $this->productSpy = new AggregateRootSpy($this->product);
        } catch (CannotCreateNewProductException $e) {
            $this->reasonWhyNewProductCannotBeCreated = $e->reason;
        }
    }

    /**
     * @Then new product should be created
     */
    public function newProductShouldBeCreated(): void
    {
        $event = $this->productSpy->findEvent(ProductCreated::class);

        Assert::assertInstanceOf(ProductCreated::class, $event, 'Product should be created');
    }

    /**
     * @Then new product should not be created, because :reason
     */
    public function newProductShouldNotBeCreatedBecause(string $reason): void
    {
        Assert::assertSame($this->reasonWhyNewProductCannotBeCreated, $reason);
    }

    /**
     * @When I rename this product to :product
     */
    public function iRenameThisProductTo(string $product): void
    {
        try {
            $this->product->rename(
                new CanIRenameProduct($this->productNameDuplicationService),
                $product,
            );
        } catch (CannotRenameProductException $e) {
            $this->reasonWhyProductCannotBeRenamed = $e->reason;
        }
    }

    /**
     * @Then this product should be renamed
     */
    public function thisProductShouldBeRenamed(): void
    {
        $event = $this->productSpy->findEvent(ProductRenamed::class);

        Assert::assertInstanceOf(ProductRenamed::class, $event, 'Product should be renamed');
    }

    /**
     * @Then this product should not be renamed, because :reason
     */
    public function thisProductShouldNotBeRenamedBecause(string $reason): void
    {
        Assert::assertSame($this->reasonWhyProductCannotBeRenamed, $reason);
    }
}
