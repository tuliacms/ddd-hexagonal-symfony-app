<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Filesystem;

use App\Product\Domain\ReadModel\Query\ProductFinderInterface;

/**
 * @author Adam Banaszkiewicz
 */
final class FilesystemProductFinder implements ProductFinderInterface
{
    public function __construct(
        private readonly ProductsStorageFactory $factory,
    ) {
    }

    public function find(string $id): ?array
    {
        return $this->factory->storage()->findOneBy(['id', '=', $id]);
    }
}
