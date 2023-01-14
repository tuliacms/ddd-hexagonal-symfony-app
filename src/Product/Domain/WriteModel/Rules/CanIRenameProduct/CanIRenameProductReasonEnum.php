<?php

declare(strict_types=1);

namespace App\Product\Domain\WriteModel\Rules\CanIRenameProduct;

/**
 * @author Adam Banaszkiewicz
 */
enum CanIRenameProductReasonEnum: string
{
    case NAME_IS_NOT_UNIQUE = 'Name is not unique';
    case OK = 'OK';
}
