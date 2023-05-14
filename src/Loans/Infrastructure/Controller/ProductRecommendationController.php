<?php

namespace App\Loans\Infrastructure\Controller;


use App\Loans\Application\UseCase\ClientUseCase;
use App\Loans\Domain\Model\Client;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
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
        private Security $security
    ){}

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     * @throws \Exception
     */
    #[Route(path: '/recommendations', name: 'recommendations_get', methods: ['GET'])]
    public function getProductRecommendations(): Response
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
}
