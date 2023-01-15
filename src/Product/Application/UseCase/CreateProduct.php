<?php

declare(strict_types=1);

namespace App\Product\Application\UseCase;

use App\Product\Domain\WriteModel\Exception\CannotCreateNewProductException;
use App\Product\Domain\WriteModel\Model\Product;
use App\Product\Domain\WriteModel\Rules\CanICreateNewProduct\CanICreateNewProductInterface;
use App\Product\Domain\WriteModel\Service\ProductRepositoryInterface;
use App\Shared\Infrastructure\Bus\Event\EventBusInterface;
use Money\Currency;
use Money\Money;

/**
 * @author Adam Banaszkiewicz
 */
final class CreateProduct
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository,
        private readonly EventBusInterface $eventBus,
        private readonly CanICreateNewProductInterface $canICreateNewProduct,
    ) {
    }

    /**
     * @throws CannotCreateNewProductException
     */
    public function __invoke(
        string $name,
        string $amount,
    ): string {
        $id = $this->repository->getNextId();
        $product = Product::create(
            $this->canICreateNewProduct,
            $id,
            $name,
            new Money($amount, new Currency('USD')),
        );

        $this->repository->save($product);
        $this->eventBus->dispatchCollection($product->collectDomainEvents());

        return $id;
    }
}
