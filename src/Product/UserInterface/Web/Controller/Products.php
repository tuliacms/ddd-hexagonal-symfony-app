<?php

declare(strict_types=1);

namespace App\Product\UserInterface\Web\Controller;

use App\Product\Application\UseCase\CreateProduct;
use App\Product\Application\UseCase\RemoveProduct;
use App\Product\Application\UseCase\UpdateProduct;
use App\Product\Domain\WriteModel\Exception\CannotCreateNewProductException;
use App\Product\Domain\WriteModel\Exception\CannotRenameProductException;
use App\Product\Domain\WriteModel\Exception\ProductDoesNotExistsException;
use App\Product\UserInterface\Web\Request\NewProductRequestModel;
use App\Product\UserInterface\Web\Request\PatchProductRequestModel;
use App\Shared\UserInterface\Web\Controller\AbstractApiController;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes as OA;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Adam Banaszkiewicz
 */
final class Products extends AbstractApiController
{
    #[OA\Post(
        path: '/api/products',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: new Model(type: NewProductRequestModel::class))
        ),
        tags: ['Products'],
        responses: [
            new OA\Response(response: Response::HTTP_CREATED, description: 'When new product created', content: new OA\MediaType(mediaType: 'application/json')),
            new OA\Response(response: Response::HTTP_BAD_REQUEST, description: 'Bad request, domain exception, contains error message', content: new OA\MediaType(mediaType: 'application/json'))
        ]
    )]
    #[Route(path: '/api/products', methods: ['POST'])]
    public function create(Request $request, CreateProduct $createProduct): Response
    {
        $data = $this->getContentFrom($request);

        try {
            $id = $createProduct($data['name'], (string) $data['price']);
        } catch (CannotCreateNewProductException $e) {
            return $this->responseBadRequest($e->reason);
        }

        return $this->responseCreated($id);
    }

    #[OA\Patch(
        path: '/api/products/{id}',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: new Model(type: PatchProductRequestModel::class))
        ),
        tags: ['Products'],
        responses: [
            new OA\Response(response: Response::HTTP_NO_CONTENT, description: 'When product updated', content: new OA\MediaType(mediaType: 'application/json')),
            new OA\Response(response: Response::HTTP_NOT_FOUND, description: 'When product does not exists', content: new OA\MediaType(mediaType: 'application/json')),
            new OA\Response(response: Response::HTTP_BAD_REQUEST, description: 'Bad request, domain exception, contains error message', content: new OA\MediaType(mediaType: 'application/json'))
        ]
    )]
    #[Route(path: '/api/products/{id}', methods: ['PATCH'])]
    public function patch(string $id, Request $request, UpdateProduct $updateProduct): Response
    {
        $data = $this->getContentFrom($request);

        if (!$data) {
            return $this->responseNoContent();
        }

        try {
            $updateProduct($id, $data['name'], (string) $data['price']);
        } catch (ProductDoesNotExistsException $e) {
            return $this->responseNotFound();
        } catch (CannotRenameProductException $e) {
            return $this->responseBadRequest($e->reason);
        }

        return $this->responseNoContent();
    }

    #[OA\Delete(
        path: '/api/products/{id}',
        tags: ['Products'],
        responses: [
            new OA\Response(response: Response::HTTP_NO_CONTENT, description: 'When product removed', content: new OA\MediaType(mediaType: 'application/json')),
            new OA\Response(response: Response::HTTP_NOT_FOUND, description: 'When product does not exists', content: new OA\MediaType(mediaType: 'application/json')),
            new OA\Response(response: Response::HTTP_BAD_REQUEST, description: 'Bad request, domain exception, contains error message', content: new OA\MediaType(mediaType: 'application/json'))
        ]
    )]
    #[Route(path: '/api/products/{id}', methods: ['DELETE'])]
    public function delete(string $id, RemoveProduct $removeProduct): Response
    {
        try {
            $removeProduct($id);
        } catch (ProductDoesNotExistsException $e) {
            return $this->responseNotFound();
        }

        return $this->responseNoContent();
    }
}
