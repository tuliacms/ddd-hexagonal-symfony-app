<?php

declare(strict_types=1);

namespace App\Cart\Domain\WriteModel\Exception;

use App\Cart\Domain\WriteModel\Rules\CanIAddProduct\CanIAddProductReasonEnum;
use App\Shared\Domain\WriteModel\Exception\AbstractDomainException;

/**
 * @author Adam Banaszkiewicz
 */
final class CannotAddProductToCartException extends AbstractDomainException
{
    private function __construct(
        string $message,
        public readonly string $reason,
    ) {
        parent::__construct($message);
    }

    public static function fromReason(CanIAddProductReasonEnum $reason, string $productId): self
    {
        return new self(sprintf('Cannot add product [%s] to cart, because: %s', $productId, $reason->value), $reason->value);
    }
}
