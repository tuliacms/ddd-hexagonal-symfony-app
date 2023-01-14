<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Filesystem;

use App\Shared\Infrastructure\Persistence\Filesystem\SleekStorage;
use SleekDB\Store;

/**
 * @author Adam Banaszkiewicz
 */
final class ProductsStorageFactory
{
    public function __construct(
        private readonly SleekStorage $storage,
    ) {
    }

    public function storage(): Store
    {
        return $this->storage->store('products');
    }
}
