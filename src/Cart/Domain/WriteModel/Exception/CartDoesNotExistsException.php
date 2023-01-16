<?php

declare(strict_types=1);

namespace App\Cart\Domain\WriteModel\Exception;

use App\Shared\Domain\WriteModel\Exception\AbstractDomainException;

/**
 * @author Adam Banaszkiewicz
 */
final class CartDoesNotExistsException extends AbstractDomainException
{
    public static function fromId(string $id): self
    {
        return new self(sprintf('Cart [%s] does not exists', $id));
    }
}
