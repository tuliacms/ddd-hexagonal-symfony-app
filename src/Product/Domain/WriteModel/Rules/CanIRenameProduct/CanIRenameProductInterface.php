<?php

declare(strict_types=1);

namespace App\Product\Domain\WriteModel\Rules\CanIRenameProduct;

/**
 * @author Adam Banaszkiewicz
 */
interface CanIRenameProductInterface
{
    public function decide(
        string $id,
        string $name,
    ): CanIRenameProductReasonEnum;
}
