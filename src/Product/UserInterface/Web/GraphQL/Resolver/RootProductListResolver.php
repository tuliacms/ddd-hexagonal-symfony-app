<?php

declare(strict_types=1);

namespace App\Product\UserInterface\Web\GraphQL\Resolver;

use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\QueryInterface;

/**
 * @author Adam Banaszkiewicz
 */
final class RootProductListResolver implements QueryInterface, AliasedInterface
{
    public function __construct()
    {
    }

    public function productList(Argument $argument): array
    {
        return [
            'pageInfo' => [
                'page' => $argument['page'],
                'pagesCount' => 0,
                'limit' => $argument['limit'],
                'totalEdges' => 0,
            ],
            'edges' => [],
        ];
    }

    public static function getAliases(): array
    {
        return ['productList' => 'root_product_list'];
    }
}
