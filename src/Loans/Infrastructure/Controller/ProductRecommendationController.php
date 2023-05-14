<?php

namespace App\Loans\Infrastructure\Controller;


use App\Loans\Domain\Model\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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
        private readonly ProductRecommendationUseCase $productRecommendationUseCase,
        private EntityManagerInterface $entityManager
    ){}

    #[Route(path: '/recommendations', name: 'recommendations_get', methods: ['GET'])]
    public function getProductRecommendations(Request $request): Response
    {
        $user = $this->entityManager->find(Client::class, 1);
        try {
            $productRecommendation = $this->productRecommendationUseCase->generateProductRecommendationForAClient($user);
            return new Response(
                $this->twig->render('@Loans/product_recommendation.html.twig', [
                    'product_recommendation' => $productRecommendation
                ])
            );
        } catch (\Exception $exception) {
            return new Response(
                $this->twig->render('@Loans/product_recommendation.html.twig', [
                    'product_recommendation' => null,
                    'error_message' => $exception->getMessage()
                ])
            );
        }
    }
}
