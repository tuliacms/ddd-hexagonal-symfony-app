<?php

declare(strict_types=1);

namespace App\Cart\UserInterface\Web\GraphQL\Resolver;

use App\Cart\Domain\ReadModel\Query\CartFinderInterface;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\QueryInterface;

/**
 * @author Adam Banaszkiewicz
 */
final class RootCartResolver implements QueryInterface, AliasedInterface
{
    public function __construct(
        private readonly CartFinderInterface $finder,
    ) {
    }

    public function cart(Argument $argument): ?array
    {
        $cart = $this->finder->find($argument['id']);

        if (!$cart) {
            return null;
        }

        return [
            '__cart_id' => $argument['id'],
            'id' => $argument['id'],
            'totalPrice' => [
                'amount' => $cart['total_price']['amount'],
                'currency' => $cart['total_price']['currency'],
            ],
            'items' => $this->resolveItems($cart['products']),
        ];
    }

    public static function getAliases(): array
    {
        return ['cart' => 'root_cart'];
    }

    private function resolveItems(array $items): array
    {
        $result = [];

        foreach ($items as $item) {
            $result[] = [
                '__product_id' => $item['product_id'],
                'productId' => $item['product_id'],
                'singularPrice' => [
                    'amount' => $item['singular_price']['amount'],
                    'currency' => $item['singular_price']['currency'],
                ],
                'totalPrice' => [
                    'amount' => $item['total_price']['amount'],
                    'currency' => $item['total_price']['currency'],
                ],
                'qty' => $item['qty'],
            ];
        }

        return $result;
    }
}
