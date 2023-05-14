<?php

namespace App\Loans\Application\UseCase;

use App\Loans\Domain\Model\ClientProduct;
use App\Loans\Domain\Model\ProductRecommendation;
use App\Loans\Domain\Repository\ResourceRepositoryInterface;

class ClientProductUseCase
{
    public function __construct(
        private readonly ResourceRepositoryInterface $clientProductRepository
    ){}

    public function createNewFromRecommendation(ProductRecommendation $productRecommendation): ClientProduct
    {
        $clientProduct = new ClientProduct($productRecommendation);
        $this->clientProductRepository->saveAndFlush($clientProduct);

        return $clientProduct;
    }
}
