<?php

namespace App\Loans\Application\UseCase;

use App\Loans\Domain\Exception\InvalidFinancialPreferencesException;
use App\Loans\Domain\Model\Product;
use App\Loans\Domain\Model\ProductRecommendation;
use App\Loans\Domain\Model\Client;
use App\Loans\Domain\Repository\ResourceRepositoryInterface;
use Symfony\Component\Translation\TranslatableMessage;

class ProductRecommendationUseCase
{
    public function __construct(
        private readonly ResourceRepositoryInterface $productRepository,
        private readonly ResourceRepositoryInterface $productRecommendationRepository
    ){}

    /**
     * @throws \Exception
     */
    public function generateProductRecommendationForAClient(Client $client): ?ProductRecommendation
    {

        $existingActiveRecommendation = $this->productRecommendationRepository->findByCriteria([
            'status' => ProductRecommendation::STATUS_CREATED,
            'client' => $client->getId()
        ]);

        if (!empty($existingActiveRecommendation)) {
            return $existingActiveRecommendation[0];
        }

        /** @var array $availableProducts */
        $availableProducts = $this->productRepository->all();

        try {
            $scoresByProduct = array_reduce($availableProducts, function ($arr, Product $product) use ($client){
                $arr[strval($product->getId())] = $product->getClientFinancialCompatibilityScore($client);
                return $arr;
            }, []);

        } catch (InvalidFinancialPreferencesException $e) {
            throw new \Exception(new TranslatableMessage('loans.exceptions.useCase.invalidFinancialPreferences'));
        }

        if (empty($scoresByProduct)) {
            return null;
        }

        if (count($scoresByProduct) === 1) {
            return $scoresByProduct;
        }

        //If there are more than one compatible product, we have to choose the one of highest score in order
        // to give the best recommendation to the user
        arsort($scoresByProduct, SORT_NUMERIC);
        $productId = array_key_first($scoresByProduct);
        foreach ($availableProducts as $product) {
            if($product->getId() === $productId) {
                $productRecommendation = new ProductRecommendation($client, $product);
                $this->productRecommendationRepository->saveAndFlush($productRecommendation);

                return $productRecommendation;
            }
        }

        return null;
    }
}
