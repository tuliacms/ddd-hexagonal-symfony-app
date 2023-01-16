<?php

declare(strict_types=1);

namespace App\Product\UserInterface\Web\Request;

use OpenApi\Attributes as OA;

/**
 * @author Adam Banaszkiewicz
 */
#[OA\Schema(schema: 'NewProductRequestModel', required: ['name', 'price'], type: 'object')]
final class NewProductRequestModel
{
    #[OA\Property(type: 'string', example: 'Fallout')]
    public string $name;

    #[OA\Property(type: 'int', example: '199')]
    public int $price;
}
