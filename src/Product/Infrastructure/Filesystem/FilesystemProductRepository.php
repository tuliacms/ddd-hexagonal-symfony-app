<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Filesystem;

use App\Product\Domain\WriteModel\Exception\ProductDoesNotExistsException;
use App\Product\Domain\WriteModel\Model\Product;
use App\Product\Domain\WriteModel\Service\ProductRepositoryInterface;
use SleekDB\Exceptions\InvalidArgumentException;
use SleekDB\Exceptions\IOException;
use Symfony\Component\Uid\Uuid;

/**
 * @author Adam Banaszkiewicz
 */
final class FilesystemProductRepository implements ProductRepositoryInterface
{
    public function __construct(
        private readonly ProductsStorageFactory $factory,
    ) {
    }

    public function getNextId(): string
    {
        return (string) Uuid::v4();
    }

    public function save(Product $product): void
    {
        $this->factory->storage()->insert($product->toArray());
    }

    /**
     * @throws ProductDoesNotExistsException
     */
    public function get(string $id): Product
    {
        $product = $this->factory->storage()->findOneBy(['id', '=', $id]);

        if (!$product) {
            throw ProductDoesNotExistsException::fromId($id);
        }

        return Product::fromArray($product);
    }

    public function delete(Product $product): void
    {
        $this->factory->storage()->deleteBy(['id', '=', $product->getId()]);
    }
}
