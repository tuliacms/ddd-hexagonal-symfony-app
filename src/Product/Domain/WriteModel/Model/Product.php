<?php

declare(strict_types=1);

namespace App\Product\Domain\WriteModel\Model;

use App\Product\Domain\WriteModel\Event\ProductCreated;
use App\Product\Domain\WriteModel\Event\ProductPriceChanged;
use App\Product\Domain\WriteModel\Event\ProductRenamed;
use App\Product\Domain\WriteModel\Exception\CannotCreateNewProductException;
use App\Product\Domain\WriteModel\Exception\CannotRenameProductException;
use App\Product\Domain\WriteModel\Rules\CanICreateNewProduct\CanICreateNewProductInterface;
use App\Product\Domain\WriteModel\Rules\CanICreateNewProduct\CanICreateNewProductReasonEnum;
use App\Product\Domain\WriteModel\Rules\CanIRenameProduct\CanIRenameProduct;
use App\Product\Domain\WriteModel\Rules\CanIRenameProduct\CanIRenameProductReasonEnum;
use App\Shared\Domain\WriteModel\Model\AbstractAggregateRoot;
use Money\Currency;
use Money\Money;

/**
 * @author Adam Banaszkiewicz
 */
final class Product extends AbstractAggregateRoot
{
    private function __construct(
        private readonly string $id,
        private string $name,
        private Money $price,
    ) {
        $this->recordThat(new ProductCreated(
            $this->id,
            $this->name,
            $this->price->getAmount(),
            $this->price->getCurrency()->getCode()
        ));
    }

    /**
     * @throws CannotCreateNewProductException
     */
    public static function create(
        CanICreateNewProductInterface $rules,
        string $id,
        string $name,
        Money $price,
    ): self {
        $reason = $rules->decide($id, $name);

        if ($reason !== CanICreateNewProductReasonEnum::OK) {
            throw CannotCreateNewProductException::fromName($reason, $name);
        }

        return new self($id, $name, $price);
    }

    public static function fromArray(array $product): self
    {
        return new self(
            $product['id'],
            $product['name'],
            new Money($product['price']['amount'], new Currency($product['price']['currency'])),
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => [
                'amount' => $this->price->getAmount(),
                'currency' => $this->price->getCurrency()->getCode(),
            ],
        ];
    }

    /**
     * @throws CannotRenameProductException
     */
    public function rename(
        CanIRenameProduct $rules,
        string $newName,
    ) {
        $reason = $rules->decide($this->id, $newName);

        if ($reason !== CanIRenameProductReasonEnum::OK) {
            throw CannotRenameProductException::fromName($reason, $newName);
        }

        $this->name = $newName;
        $this->recordThat(new ProductRenamed($this->id, $newName));
    }

    public function changePrice(string $amount): void
    {
        $this->price = new Money($amount, $this->price->getCurrency());
        $this->recordThat(new ProductPriceChanged($this->id, $this->price->getAmount(), $this->price->getCurrency()->getCode()));
    }
}
