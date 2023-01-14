<?php

declare(strict_types=1);

namespace App\Shared\Domain\ReadModel\Query;

/**
 * @author Adam Banaszkiewicz
 */
abstract class AbstractPaginatedCollectionRequest
{
    public readonly int $page;
    public readonly int $limit;
    public readonly int $queryOffset;

    public function __construct(
        int $page,
        int $limit,
    ) {
        if ($page <= 1) {
            $page = 1;
        }

        $this->page = $page;

        if ($limit <= 0) {
            $limit = 1;
        } elseif ($limit > 100) {
            $limit = 100;
        }

        $this->limit = $limit;
        $this->queryOffset = ($this->page - 1) * $this->limit;
    }
}
