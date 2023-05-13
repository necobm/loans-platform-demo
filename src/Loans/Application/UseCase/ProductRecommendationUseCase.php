<?php

namespace App\Loans\Application\UseCase;

use App\Loans\Domain\Model\User;
use App\Loans\Domain\Repository\ResourceRepositoryInterface;

class ProductRecommendationUseCase
{
    public function __construct(
        private readonly ResourceRepositoryInterface $productRepository
    ){}

    public function generateProductRecommendationForAnUser(User $user)
    {
        $availableProducts = $this->productRepository->all();

        return $availableProducts;
    }
}
