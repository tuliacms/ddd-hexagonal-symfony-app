<?php

declare(strict_types=1);

namespace App\Cart\UserInterface\Web\Request;

use OpenApi\Attributes as OA;

/**
 * @author Adam Banaszkiewicz
 */
#[OA\Schema(schema: 'AddProductToCart', required: ['id', 'qty'], type: 'object')]
final class AddProductToCart
{
    #[OA\Property(type: 'string', example: 'a37a0c28-7c68-46ab-9f6e-2d0bc6c003cc')]
    public string $id;

    #[OA\Property(type: 'int', example: '1')]
    public int $qty;
}
