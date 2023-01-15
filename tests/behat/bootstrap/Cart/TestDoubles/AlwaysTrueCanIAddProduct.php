<?php

declare(strict_types=1);

namespace App\Tests\behat\bootstrap\Cart\TestDoubles;

use App\Cart\Domain\WriteModel\Model\Product;
use App\Cart\Domain\WriteModel\Rules\CanIAddProduct\CanIAddProductInterface;
use App\Cart\Domain\WriteModel\Rules\CanIAddProduct\CanIAddProductReasonEnum;

/**
 * @author Adam Banaszkiewicz
 */
final class AlwaysTrueCanIAddProduct implements CanIAddProductInterface
{
    public function decide(
        string $productId,
        int $qty,
        array $productsQtyList,
        ?Product $product,
    ): CanIAddProductReasonEnum {
        return CanIAddProductReasonEnum::OK;
    }
}
