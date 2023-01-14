<?php

declare(strict_types=1);

namespace App\Product\Domain\WriteModel\Service;

use App\Product\Domain\WriteModel\Exception\ProductDoesNotExistsException;
use App\Product\Domain\WriteModel\Model\Product;

/**
 * @author Adam Banaszkiewicz
 */
interface ProductRepositoryInterface
{
    public function getNextId(): string;

    public function save(Product $product): void;

    /**
     * @throws ProductDoesNotExistsException
     */
    public function get(string $id): Product;

    public function delete(Product $product): void;
}
