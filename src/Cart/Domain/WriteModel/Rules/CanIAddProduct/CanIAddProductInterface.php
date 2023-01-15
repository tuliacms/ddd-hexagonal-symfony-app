<?php

declare(strict_types=1);

namespace App\Cart\Domain\WriteModel\Rules\CanIAddProduct;

use App\Cart\Domain\WriteModel\Model\Product;

/**
 * @author Adam Banaszkiewicz
 */
interface CanIAddProductInterface
{
    public function decide(
        string $productId,
        int $qty,
        array $productsQtyList,
        ?Product $product,
    ): CanIAddProductReasonEnum;
}
