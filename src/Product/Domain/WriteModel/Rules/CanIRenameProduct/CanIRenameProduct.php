<?php

declare(strict_types=1);

namespace App\Product\Domain\WriteModel\Rules\CanIRenameProduct;

use App\Product\Domain\WriteModel\Service\ProductNameDuplicationServiceInterface;

/**
 * @author Adam Banaszkiewicz
 */
final class CanIRenameProduct implements CanIRenameProductInterface
{
    public function __construct(
        private readonly ProductNameDuplicationServiceInterface $productNameDuplicationService,
    ) {
    }

    public function decide(
        string $id,
        string $name,
    ): CanIRenameProductReasonEnum {
        if ($this->thereIsAnotherProductWithThisName($name, $id)) {
            return CanIRenameProductReasonEnum::NAME_IS_NOT_UNIQUE;
        }

        return CanIRenameProductReasonEnum::OK;
    }

    private function thereIsAnotherProductWithThisName(string $name, string $id): bool
    {
        return $this->productNameDuplicationService->isNameDuplicated($name, $id);
    }
}
