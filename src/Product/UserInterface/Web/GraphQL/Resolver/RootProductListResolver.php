<?php

declare(strict_types=1);

namespace App\Product\UserInterface\Web\GraphQL\Resolver;

use App\Product\Domain\ReadModel\Model\ProductsRequest;
use App\Product\Domain\ReadModel\Query\PaginatedProductsFinderInterface;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\QueryInterface;

/**
 * @author Adam Banaszkiewicz
 */
final class RootProductListResolver implements QueryInterface, AliasedInterface
{
    public function __construct(
        private readonly PaginatedProductsFinderInterface $finder,
    ) {
    }

    public function productList(Argument $argument): array
    {
        $limit = $argument['limit'] >= 3 ? 3 : $argument['limit'];
        $request = new ProductsRequest($argument['page'], $limit);
        $collection = $this->finder->find($request);

        return [
            'pageInfo' => [
                'page' => $request->page,
                'pagesCount' => $collection->pagesCount,
                'limit' => $request->limit,
                'totalEdges' => $collection->totalEdges,
            ],
            'edges' => $collection->edges,
        ];
    }

    public static function getAliases(): array
    {
        return ['productList' => 'root_product_list'];
    }
}
