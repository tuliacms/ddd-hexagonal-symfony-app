<?php

declare(strict_types=1);

namespace App\Cart\Domain\ReadModel\Query;

/**
 * @author Adam Banaszkiewicz
 */
interface CartFinderInterface
{
    public function find(string $id): ?array;
}
