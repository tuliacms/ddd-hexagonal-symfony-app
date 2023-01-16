<?php

declare(strict_types=1);

namespace App\Product\UserInterface\Web\GraphQL\Resolver;

use App\Product\Domain\ReadModel\Query\ProductFinderInterface;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\QueryInterface;

/**
 * @author Adam Banaszkiewicz
 */
final class ProductResolver implements QueryInterface, AliasedInterface
{
    public function __construct(
        private readonly ProductFinderInterface $finder,
    ) {
    }

    public function product(array $value): ?array
    {
        return $this->finder->find($value['__product_id']);
    }

    public static function getAliases(): array
    {
        return ['product' => 'product_single'];
    }
}
