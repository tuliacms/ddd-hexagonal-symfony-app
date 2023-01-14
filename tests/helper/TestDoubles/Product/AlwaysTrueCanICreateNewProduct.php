<?php

declare(strict_types=1);

namespace App\Tests\helper\TestDoubles\Product;

use App\Product\Domain\WriteModel\Rules\CanICreateNewProduct\CanICreateNewProductInterface;
use App\Product\Domain\WriteModel\Rules\CanICreateNewProduct\CanICreateNewProductReasonEnum;

/**
 * @author Adam Banaszkiewicz
 */
final class AlwaysTrueCanICreateNewProduct implements CanICreateNewProductInterface
{
    public function decide(string $id, string $name,): CanICreateNewProductReasonEnum
    {
        return CanICreateNewProductReasonEnum::OK;
    }
}
