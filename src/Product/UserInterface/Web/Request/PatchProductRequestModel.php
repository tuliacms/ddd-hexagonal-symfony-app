<?php

declare(strict_types=1);

namespace App\Product\UserInterface\Web\Request;

use OpenApi\Attributes as OA;

/**
 * @author Adam Banaszkiewicz
 */
#[OA\Schema(schema: 'PatchProductRequestModel', type: 'object')]
final class PatchProductRequestModel
{
    #[OA\Property(type: 'string', example: 'Fallout', nullable: true)]
    public string $name;

    #[OA\Property(type: 'int', example: '199', nullable: true)]
    public int $price;
}
