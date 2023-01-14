<?php

declare(strict_types=1);

namespace App\Product\Domain\WriteModel\Rules\CanICreateNewProduct;

/**
 * @author Adam Banaszkiewicz
 */
enum CanICreateNewProductReasonEnum: string
{
    case NAME_IS_NOT_UNIQUE = 'Name is not unique';
    case OK = 'OK';
}
