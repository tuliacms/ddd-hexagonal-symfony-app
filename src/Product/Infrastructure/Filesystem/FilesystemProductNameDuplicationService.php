<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Filesystem;

use App\Product\Domain\WriteModel\Service\ProductNameDuplicationServiceInterface;

/**
 * @author Adam Banaszkiewicz
 */
final class FilesystemProductNameDuplicationService implements ProductNameDuplicationServiceInterface
{
    public function __construct(
        private readonly ProductsStorageFactory $factory,
    ) {
    }

    public function isNameDuplicated(string $name, string $currentProductId): bool
    {
        return [] !== $this->factory->storage()
            ->createQueryBuilder()
            ->select(['id'])
            ->where(['name', '=', $name])
            ->where(['name', '!=', $currentProductId])
            ->getQuery()
            ->first();
    }
}
