<?php

declare(strict_types=1);

namespace App\Product\UserInterface\OpenHost\Query;

/**
 * @author Adam Banaszkiewicz
 */
final class ProductService
{
    public function __construct()
    {
    }

    public function findProduct(string $id): ?array
    {
        return [
            'id' => $id,
            'price' => [
                'amount' => '199',
                'currency' => 'USD',
            ],
        ];
    }
}
