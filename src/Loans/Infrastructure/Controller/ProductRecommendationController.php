<?php

namespace App\Loans\Infrastructure\Controller;


use App\Loans\Domain\Model\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use App\Loans\Application\UseCase\ProductRecommendationUseCase;

#[AsController]
class ProductRecommendationController
{
    public function __construct(
        private readonly Environment $twig,
        private readonly ProductRecommendationUseCase $productRecommendationUseCase
    ){}

    #[Route(path: '/loans/recommendations', name: 'recommendations_get', methods: ['GET'])]
    public function getProductRecommendations(): Response
    {
        $products = $this->productRecommendationUseCase->generateProductRecommendationForAnUser(new User());

        return new Response(
            $this->twig->render('@Loans/product_recommendation.html.twig', [
                'products_count' => count($products)
            ])
        );
    }
}
