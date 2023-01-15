<?php

declare(strict_types=1);

namespace App\Cart\Domain\WriteModel\Rules\CanIAddProduct;

/**
 * @author Adam Banaszkiewicz
 */
enum CanIAddProductReasonEnum: string
{
    case ProductDoesNotExists = 'Product does not exists';
    case QtyLimitForOneProductExceeded = 'Qty limit for one product exceeded';
    case LimitOfProductsInCartExceeded = 'Limit of products in cart exceeded';
    case OK = 'OK';
}
