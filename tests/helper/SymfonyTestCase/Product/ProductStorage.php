<?php

declare(strict_types=1);

namespace App\Tests\helper\SymfonyTestCase\Product;

use App\Product\Infrastructure\Filesystem\ProductsStorageFactory;
use App\Shared\Infrastructure\Persistence\Filesystem\SleekStorage;

/**
 * @author Adam Banaszkiewicz
 */
final class ProductStorage
{
    public function __construct(
        private readonly ProductsStorageFactory $factory,
    ) {
    }

    public function productExists(string $id): bool
    {
        return [] !== $this->factory->storage()->findOneBy(['id', '=', $id]);
    }
}
