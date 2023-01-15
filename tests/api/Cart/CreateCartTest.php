<?php

declare(strict_types=1);

namespace App\Tests\api\Cart;

use App\Tests\api\AbstractApiTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Adam Banaszkiewicz
 */
final class CreateCartTest extends AbstractApiTestCase
{
    public function test_create_cart(): void
    {
        // When
        $this->request('POST', '/api/carts');

        // Then
        self::assertResponseStatusCodeSame(Response::HTTP_CREATED);
        self::assertResponseHasIdField();
    }
}
