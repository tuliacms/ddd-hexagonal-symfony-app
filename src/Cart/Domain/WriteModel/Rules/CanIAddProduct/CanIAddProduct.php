<?php

declare(strict_types=1);

namespace App\Cart\Domain\WriteModel\Rules\CanIAddProduct;

use App\Cart\Domain\WriteModel\Model\Product;

/**
 * @author Adam Banaszkiewicz
 */
final class CanIAddProduct implements CanIAddProductInterface
{
    private const PRODUCTS_QTY_LIMIT = 10;

    public function decide(
        string $productId,
        int $qty,
        array $productsQtyList,
        ?Product $product,
    ): CanIAddProductReasonEnum {
        if ($this->productDoesNotExists($product)) {
            return CanIAddProductReasonEnum::ProductDoesNotExists;
        }
        if ($this->limitOfProductsInCartExceeded($productsQtyList, $productId)) {
            return CanIAddProductReasonEnum::LimitOfProductsInCartExceeded;
        }
        if ($this->newProductQtyExceedesLimit($productId, $qty, $productsQtyList)) {
            return CanIAddProductReasonEnum::QtyLimitForOneProductExceeded;
        }

        return CanIAddProductReasonEnum::OK;
    }

    private function newProductQtyExceedesLimit(string $productId, int $qty, array $productsQtyList): bool
    {
        $current = $productsQtyList[$productId] ?? 0;

        return ($current + $qty) > self::PRODUCTS_QTY_LIMIT;
    }

    private function productDoesNotExists(?Product $product): bool
    {
        return !$product;
    }

    private function limitOfProductsInCartExceeded(array $productsQtyList, string $productId): bool
    {
        if (isset($productsQtyList[$productId])) {
            return false;
        }

        return count($productsQtyList) >= 3;
    }
}
