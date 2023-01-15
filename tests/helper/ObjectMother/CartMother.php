<?php

declare(strict_types=1);

namespace App\Tests\helper\ObjectMother;

use App\Cart\Domain\WriteModel\Model\Cart;
use App\Cart\Domain\WriteModel\Service\ProductFinderInterface;
use App\Tests\behat\bootstrap\Cart\TestDoubles\AlwaysTrueCanIAddProduct;
use Symfony\Component\Uid\Uuid;

/**
 * @author Adam Banaszkiewicz
 */
final class CartMother
{
    private array $products = [];

    private function __construct() {
    }

    public static function aCart(): self
    {
        return new self();
    }

    public function withProduct(string $product, int $qty): self
    {
        $this->products[] = ['id' => $product, 'qty' => $qty];
        return $this;
    }

    public function build(
        ProductFinderInterface $productFinder,
    ): Cart {
        $cart = Cart::create((string) Uuid::v4());

        foreach ($this->products as $product) {
            $cart->addProduct(
                new AlwaysTrueCanIAddProduct(),
                $productFinder,
                $product['id'],
                $product['qty'],
            );
        }
        $cart->collectDomainEvents();

        return $cart;
    }
}
