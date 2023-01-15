<?php

declare(strict_types=1);

namespace App\Tests\helper\ObjectMother;

use App\Cart\Domain\WriteModel\Event\AbstractEventSourcingEvent;
use App\Cart\Domain\WriteModel\Event\CartCreated;
use App\Cart\Domain\WriteModel\Event\ProductAddedToCart;
use App\Cart\Domain\WriteModel\Model\Cart;
use App\Cart\Domain\WriteModel\Service\ProductFinderInterface;
use Symfony\Component\Uid\Uuid;

/**
 * @author Adam Banaszkiewicz
 */
final class CartMother
{
    private string $id;
    /** @var AbstractEventSourcingEvent[] */
    private array $events = [];

    private function __construct() {
        $this->id = (string) Uuid::v4();
        $this->events[] = new CartCreated($this->id);
    }

    public static function aCart(): self
    {
        return new self();
    }

    public function withProduct(string $productId, int $qty, ProductFinderInterface $productFinder): self
    {
        $product = $productFinder->find($productId);

        $this->events[] = new ProductAddedToCart(
            $this->id,
            $productId,
            $qty,
            $product->getPrice()->getAmount(),
            $product->getPrice()->getCurrency()-> getCode(),
        );

        return $this;
    }

    public function build(): Cart
    {
        return Cart::regenerateFromEvents($this->events);
    }
}
