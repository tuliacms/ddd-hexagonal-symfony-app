<?php

declare(strict_types=1);

namespace App\Cart\UserInterface\Web\Controller;

use App\Cart\Application\UseCase\AddProduct;
use App\Cart\Application\UseCase\CreateCart;
use App\Cart\Application\UseCase\RemoveProduct;
use App\Cart\Domain\WriteModel\Exception\CannotAddProductToCartException;
use App\Cart\Domain\WriteModel\Exception\CartDoesNotExistsException;
use App\Cart\UserInterface\Web\Request\AddProductToCartRequestModel;
use App\Shared\UserInterface\Web\Controller\AbstractApiController;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Adam Banaszkiewicz
 */
final class CartProducts extends AbstractApiController
{
    #[OA\Post(
        path: '/api/carts/{id}/products',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: new Model(type: AddProductToCartRequestModel::class))
        ),
        tags: ['Carts'],
        responses: [
            new OA\Response(response: Response::HTTP_CREATED, description: 'When products added to cart', content: new OA\MediaType(mediaType: 'application/json')),
            new OA\Response(response: Response::HTTP_NOT_FOUND, description: 'When cart does not exists', content: new OA\MediaType(mediaType: 'application/json')),
            new OA\Response(response: Response::HTTP_BAD_REQUEST, description: 'Bad request, domain exception, contains error message', content: new OA\MediaType(mediaType: 'application/json'))
        ]
    )]
    #[Route(path: '/api/carts/{id}/products', methods: ['POST'])]
    public function add(string $id, Request $request, AddProduct $addProduct): Response
    {
        $data = $this->getContentFrom($request);

        try {
            $addProduct($id, $data['id'], $data['qty']);
        } catch (CartDoesNotExistsException $e) {
            return $this->responseNotFound();
        } catch (CannotAddProductToCartException $e) {
            return $this->responseBadRequest($e->reason);
        }

        return $this->responseCreated($id);
    }

    #[OA\Delete(
        path: '/api/carts/{id}/products/{product}',
        tags: ['Carts'],
        responses: [
            new OA\Response(response: Response::HTTP_NO_CONTENT, description: 'When products removed from cart', content: new OA\MediaType(mediaType: 'application/json')),
            new OA\Response(response: Response::HTTP_NOT_FOUND, description: 'When cart does not exists', content: new OA\MediaType(mediaType: 'application/json')),
            new OA\Response(response: Response::HTTP_BAD_REQUEST, description: 'Bad request, domain exception, contains error message', content: new OA\MediaType(mediaType: 'application/json'))
        ]
    )]
    #[Route(path: '/api/carts/{id}/products/{product}', methods: ['DELETE'])]
    public function delete(string $id, string $product, RemoveProduct $removeProduct): Response
    {
        try {
            $removeProduct($id, $product);
        } catch (CartDoesNotExistsException $e) {
            return $this->responseNotFound();
        }

        return $this->responseNoContent();
    }
}
