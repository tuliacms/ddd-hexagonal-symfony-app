<?php

declare(strict_types=1);

namespace App\Cart\UserInterface\Web\Controller;

use App\Cart\Application\UseCase\CreateCart;
use App\Shared\UserInterface\Web\Controller\AbstractApiController;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Adam Banaszkiewicz
 */
final class Carts extends AbstractApiController
{
    #[OA\Post(
        path: '/api/carts',
        tags: ['Carts'],
        responses: [
            new OA\Response(response: Response::HTTP_CREATED, description: 'When new cart created', content: new OA\MediaType(mediaType: 'application/json')),
            new OA\Response(response: Response::HTTP_BAD_REQUEST, description: 'Bad request, domain exception, contains error message', content: new OA\MediaType(mediaType: 'application/json'))
        ]
    )]
    #[Route(path: '/api/carts', methods: ['POST'])]
    public function create(CreateCart $createCart): Response
    {
        $id = $createCart();

        return $this->responseCreated($id);
    }
}
