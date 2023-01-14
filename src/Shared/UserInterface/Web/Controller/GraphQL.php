<?php

declare(strict_types=1);

namespace App\Shared\UserInterface\Web\Controller;

use OpenApi\Attributes as OA;
use Overblog\GraphQLBundle\Controller\GraphController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Adam Banaszkiewicz
 */
final class GraphQL extends GraphController
{
    #[OA\Post(
        path: '/api/graphql',
        requestBody: new OA\RequestBody(
            required: true,
            content: [
                new OA\MediaType(mediaType: 'application/graphql', schema: new OA\Schema(type: 'object', example: 'query {}')),
            ],
        ),
        tags: ['GraphQL'],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: 'GraphQL JSON Response', content: new OA\MediaType(mediaType: 'application/json')),
            new OA\Response(response: Response::HTTP_BAD_REQUEST, description: 'Bad request, domain exception, contains error message', content: new OA\MediaType(mediaType: 'application/json')),
        ]
    )]
    #[Route(path: '/api/graphql', methods: ['POST'])]
    public function handle(Request $request): Response
    {
        return $this->endpointAction($request, 'query');
    }
}
