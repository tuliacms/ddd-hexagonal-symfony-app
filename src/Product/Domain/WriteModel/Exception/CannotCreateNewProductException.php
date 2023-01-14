<?php

declare(strict_types=1);

namespace App\Product\Domain\WriteModel\Exception;

use App\Product\Domain\WriteModel\Rules\CanICreateNewProduct\CanICreateNewProductReasonEnum;
use App\Shared\Domain\WriteModel\Exception\AbstractDomainException;

/**
 * @author Adam Banaszkiewicz
 */
final class CannotCreateNewProductException extends AbstractDomainException
{
    private function __construct(
        string $message,
        public readonly string $reason,
    ) {
        parent::__construct($message);
    }

    public static function fromName(CanICreateNewProductReasonEnum $reason, string $name): self
    {
        return new self(sprintf('Cannot create new product [%s], because: %s', $name, $reason->value), $reason->value);
    }
}
