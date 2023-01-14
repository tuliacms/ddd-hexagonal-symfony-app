<?php

declare(strict_types=1);

namespace App\Product\Domain\ReadModel\Query;

use App\Product\Domain\ReadModel\Model\ProductsCollection;
use App\Product\Domain\ReadModel\Model\ProductsRequest;

/**
 * @author Adam Banaszkiewicz
 */
interface PaginatedProductsFinderInterface
{
    public function find(ProductsRequest $request): ProductsCollection;
}
