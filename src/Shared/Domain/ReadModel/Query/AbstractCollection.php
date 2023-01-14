<?php

declare(strict_types=1);

namespace App\Shared\Domain\ReadModel\Query;

/**
 * @author Adam Banaszkiewicz
 */
abstract class AbstractCollection
{
    public readonly int $pagesCount;

    /**
     * @param object[] $edges
     */
    public function __construct(
        public readonly int $page,
        public readonly int $limit,
        public readonly int $totalEdges,
        public readonly array $edges,
    ) {
        $this->pagesCount = (int) ceil($this->totalEdges / $this->limit);
    }
}
