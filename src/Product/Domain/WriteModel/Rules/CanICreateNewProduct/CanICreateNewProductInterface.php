<?php

declare(strict_types=1);

namespace App\Product\Domain\WriteModel\Rules\CanICreateNewProduct;

/**
 * @author Adam Banaszkiewicz
 */
interface CanICreateNewProductInterface
{
    public function decide(
        string $id,
        string $name,
    ): CanICreateNewProductReasonEnum;
}
