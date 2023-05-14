<?php

namespace App\Loans\Infrastructure\Controller;


use App\Loans\Application\UseCase\ClientUseCase;
use App\Loans\Domain\Exception\ResourceNotFoundException;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use App\Loans\Application\UseCase\ProductRecommendationUseCase;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

#[AsController]
class ProductRecommendationController
{
    public function __construct(
        private readonly Environment $twig,
        private readonly ProductRecommendationUseCase $productRecommendationUseCase,
        private readonly ClientUseCase $clientUseCase,
        private readonly Security $security
    ){}

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     * @throws \Exception
     */
    #[Route(path: '/recommendations', name: 'recommendations_get', methods: ['GET'])]
    public function getProductRecommendations(AdminUrlGenerator $adminUrlGenerator): Response
    {
        $user = $this->security->getUser();
        $client = $this->clientUseCase->getClientByEmail($user->getUserIdentifier());

        if (is_null($client)) {
            throw new \Exception("The current user doesn't have a client associated");
        }

        try {
            $productRecommendation = $this->productRecommendationUseCase->generateProductRecommendationForAClient($client);

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

    /**
     * @throws \Exception
     */
    #[Route(path: '/recommendations/{id}/accept', name: 'recommendations_accept', methods: ['GET'])]
    public function acceptProductRecommendation(int $id): Response
    {
        $productRecommendation = $this->productRecommendationUseCase->acceptProductRecommendation($id);
        return new Response(
            $this->twig->render('@Loans/product_recommendation_status.html.twig', [
                'status' => 'success'
            ])
        );
    }

    /**
     * @param int $id
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws ResourceNotFoundException
     */
    #[Route(path: '/recommendations/{id}/reject', name: 'recommendations_reject', methods: ['GET'])]
    public function rejectRecommendation(int $id): Response
    {
        $productRecommendation = $this->productRecommendationUseCase->rejectProductRecommendation($id);
        return new Response(
            $this->twig->render('@Loans/product_recommendation_status.html.twig', [
                'status' => 'rejected'
            ])
        );
    }
}
