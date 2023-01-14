<?php

declare(strict_types=1);

namespace App\Product\Domain\WriteModel\Rules\CanICreateNewProduct;

use App\Product\Domain\WriteModel\Service\ProductNameDuplicationServiceInterface;

/**
 * @author Adam Banaszkiewicz
 */
final class CanICreateNewProduct implements CanICreateNewProductInterface
{
    public function __construct(
        private readonly ProductNameDuplicationServiceInterface $productNameDuplicationService,
    ) {
    }

    public function decide(
        string $id,
        string $name,
    ): CanICreateNewProductReasonEnum {
        if ($this->thereIsAnotherProductWithThisName($name, $id)) {
            return CanICreateNewProductReasonEnum::NAME_IS_NOT_UNIQUE;
        }

        return CanICreateNewProductReasonEnum::OK;
    }

    private function thereIsAnotherProductWithThisName(string $name, string $id): bool
    {
        return $this->productNameDuplicationService->isNameDuplicated($name, $id);
    }
}
