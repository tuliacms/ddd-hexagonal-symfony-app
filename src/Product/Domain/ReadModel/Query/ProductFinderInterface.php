<?php

declare(strict_types=1);

namespace App\Product\Domain\ReadModel\Query;

/**
 * @author Adam Banaszkiewicz
 */
interface ProductFinderInterface
{
    public function find(string $id): ?array;
}
