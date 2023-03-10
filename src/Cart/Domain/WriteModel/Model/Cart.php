<?php

declare(strict_types=1);

namespace App\Cart\Domain\WriteModel\Model;

use App\Cart\Domain\WriteModel\Event\CartCreated;
use App\Cart\Domain\WriteModel\Event\ProductAddedToCart;
use App\Cart\Domain\WriteModel\Event\ProductQtyIncreased;
use App\Cart\Domain\WriteModel\Event\ProductRemovedFromCart;
use App\Cart\Domain\WriteModel\Exception\CannotAddProductToCartException;
use App\Cart\Domain\WriteModel\Rules\CanIAddProduct\CanIAddProductInterface;
use App\Cart\Domain\WriteModel\Rules\CanIAddProduct\CanIAddProductReasonEnum;
use App\Cart\Domain\WriteModel\Service\ProductFinderInterface;
use App\Shared\Domain\WriteModel\Model\AbstractAggregateRoot;
use Money\Money;

/**
 * @author Adam Banaszkiewicz
 */
final class Cart extends AbstractAggregateRoot
{
    use CartRegenerableTrait;

    /** @var Product[] */
    private array $products = [];

    private function __construct(
        private string $id,
    ) {
    }

    public static function create(
        string $id,
    ): self {
        $self = new self($id);
        $self->recordThat(new CartCreated($id));

        return $self;
    }

    public function toArray(): array
    {
        $products = [];
        $totalPrice = Money::USD(0);

        foreach ($this->products as $product) {
            $products[] = $product->toArray();
            $sumPrice = $product->getPrice()->multiply($product->getQty());
            $totalPrice = $totalPrice->add($sumPrice);
        }

        return [
            'id' => $this->id,
            'products' => $products,
            'total_price' => [
                'amount' => $totalPrice->getAmount(),
                'currency' => $totalPrice->getCurrency()->getCode(),
            ],
        ];
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @throws CannotAddProductToCartException
     */
    public function addProduct(
        CanIAddProductInterface $rules,
        ProductFinderInterface $productFinder,
        string $productId,
        int $qty,
    ): void {
        if ($qty <= 0) {
            return;
        }

        $newProduct = $productFinder->find($productId);

        $reason = $rules->decide(
            $productId,
            $qty,
            $this->collectProductsQtyList(),
            $newProduct,
        );

        if ($reason !== CanIAddProductReasonEnum::OK) {
            throw CannotAddProductToCartException::fromReason($reason, $productId);
        }

        $existingProduct = $this->findProduct($productId);

        if ($existingProduct) {
            $existingProduct->increaseQtyOf($qty);

            $this->recordThat(new ProductQtyIncreased($this->id, $productId, $qty));
        } else {
            assert($newProduct instanceof Product);
            $newProduct->increaseQtyOf($qty);

            $this->products[] = $newProduct;
            $this->recordThat(new ProductAddedToCart(
                $this->id,
                $productId,
                $qty,
                $newProduct->getPrice()->getAmount(),
                $newProduct->getPrice()->getCurrency()->getCode(),
            ));
        }
    }

    public function removeProduct(string $productId): void
    {
        foreach ($this->products as $key => $product) {
            if ($product->isA($productId)) {
                unset($this->products[$key]);
                $this->recordThat(new ProductRemovedFromCart($this->id, $productId));
            }
        }
    }

    private function findProduct(string $productId): ?Product
    {
        foreach ($this->products as $product) {
            if ($product->isA($productId)) {
                return $product;
            }
        }

        return null;
    }

    private function collectProductsQtyList(): array
    {
        $result = [];

        foreach ($this->products as $product) {
            $result[$product->getProductId()] = $product->getQty();
        }

        return $result;
    }
}
