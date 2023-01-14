<?php

declare(strict_types=1);

namespace App\Product\Domain\WriteModel\Exception;

use App\Shared\Domain\WriteModel\Exception\AbstractDomainException;

/**
 * @author Adam Banaszkiewicz
 */
final class ProductDoesNotExistsException extends AbstractDomainException
{
    public static function fromId(string $id): self
    {
        return new self(sprintf('Product [%s] does not exists', $id));
    }
}
