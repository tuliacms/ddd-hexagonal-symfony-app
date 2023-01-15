<?php

declare(strict_types=1);

namespace App\Cart\Domain\WriteModel\Service;

use App\Cart\Domain\WriteModel\Model\Product;

/**
 * @author Adam Banaszkiewicz
 */
interface ProductFinderInterface
{
    public function find(string $id): ?Product;
}
