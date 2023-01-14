<?php

declare(strict_types=1);

namespace App\Shared\UserInterface\Web\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Adam Banaszkiewicz
 */
abstract class AbstractApiController extends AbstractController
{
    protected function getContentFrom(Request $request): array
    {
        if (!$request->getContent()) {
            return [];
        }

        return json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
    }

    protected function responseBadRequest(string $message): Response
    {
        return new JsonResponse(['message' => $message], Response::HTTP_BAD_REQUEST);
    }

    protected function responseCreated(string $id): Response
    {
        return new JsonResponse(['id' => $id], Response::HTTP_CREATED);
    }

    protected function responseNoContent(): Response
    {
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    protected function responseNotFound(): Response
    {
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
}
