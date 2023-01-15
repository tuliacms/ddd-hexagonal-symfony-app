<?php

declare(strict_types=1);

namespace App\Tests\api\Product;

use App\Tests\api\AbstractApiTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Adam Banaszkiewicz
 */
final class CreateProductTest extends AbstractApiTestCase
{
    public function test_create_product(): void
    {
        // When
        $this->request('POST', '/api/products', [
            'name' => 'Fallout',
            'price' => 199,
        ]);

        // Then
        self::assertResponseStatusCodeSame(Response::HTTP_CREATED);
        self::assertResponseHasIdField();
    }
}
