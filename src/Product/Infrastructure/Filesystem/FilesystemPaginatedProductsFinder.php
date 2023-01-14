<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Filesystem;

use App\Product\Domain\ReadModel\Model\ProductsCollection;
use App\Product\Domain\ReadModel\Model\ProductsRequest;
use App\Product\Domain\ReadModel\Query\PaginatedProductsFinderInterface;

/**
 * @author Adam Banaszkiewicz
 */
final class FilesystemPaginatedProductsFinder implements PaginatedProductsFinderInterface
{
    public function __construct(
        private readonly ProductsStorageFactory $factory,
    ) {
    }

    public function find(ProductsRequest $request): ProductsCollection
    {
        $rows = $this->factory->storage()->createQueryBuilder()
            ->orderBy(['name' => 'asc'])
            ->getQuery()
            ->fetch();

        $chunks = array_chunk($rows, $request->limit);

        return new ProductsCollection(
            $request->page,
            $request->limit,
            count($rows),
            $chunks[$request->page - 1] ?? []
        );
    }
}
