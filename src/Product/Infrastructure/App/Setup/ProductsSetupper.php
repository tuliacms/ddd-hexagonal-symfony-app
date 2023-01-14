<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\App\Setup;

use App\Product\Domain\WriteModel\Model\Product;
use App\Product\Domain\WriteModel\Rules\CanICreateNewProduct\CanICreateNewProductInterface;
use App\Product\Domain\WriteModel\Service\ProductRepositoryInterface;
use App\Shared\Infrastructure\App\Setup\AppSetupperInterface;
use App\Shared\Infrastructure\Persistence\Filesystem\SleekStorage;
use Money\Currency;
use Money\Money;

/**
 * @author Adam Banaszkiewicz
 */
class ProductsSetupper implements AppSetupperInterface
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository,
        private readonly CanICreateNewProductInterface $canICreateNewProduct,
        private readonly SleekStorage $storage,
    ) {
    }

    public function setup(): void
    {
        $this->storage->clear();

        $this->repository->save(
            Product::create(
                $this->canICreateNewProduct,
                $this->repository->getNextId(),
                'Fallout',
                new Money(199, new Currency('USD'))
            )
        );
        $this->repository->save(
            Product::create(
                $this->canICreateNewProduct,
                $this->repository->getNextId(),
                'Don’t Starve',
                new Money(299, new Currency('USD'))
            )
        );
        $this->repository->save(
            Product::create(
                $this->canICreateNewProduct,
                $this->repository->getNextId(),
                'Baldur’s Gate',
                new Money(399, new Currency('USD'))
            )
        );
        $this->repository->save(
            Product::create(
                $this->canICreateNewProduct,
                $this->repository->getNextId(),
                'Icewind Dale',
                new Money(499, new Currency('USD'))
            )
        );
        $this->repository->save(
            Product::create(
                $this->canICreateNewProduct,
                $this->repository->getNextId(),
                'Bloodborne',
                new Money(599, new Currency('USD'))
            )
        );
    }
}
