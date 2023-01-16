<?php

declare(strict_types=1);

namespace App\Product\UserInterface\OpenHost\Query;

use App\Product\Domain\ReadModel\Query\ProductFinderInterface;

/**
 * @author Adam Banaszkiewicz
 */
final class ProductService
{
    public function __construct(
        private readonly ProductFinderInterface $finder,
    ) {
    }

    public function findProduct(string $id): ?array
    {
        return $this->finder->find($id);
    }
}
