<?php

namespace App\Loans\Application\UseCase;

use App\Loans\Domain\Exception\InvalidFinancialPreferencesException;
use App\Loans\Domain\Exception\ResourceNotFoundException;
use App\Loans\Domain\Model\Product;
use App\Loans\Domain\Model\ProductRecommendation;
use App\Loans\Domain\Model\Client;
use App\Loans\Domain\Repository\ResourceRepositoryInterface;
use Symfony\Component\Translation\TranslatableMessage;

class ProductRecommendationUseCase
{
    public function __construct(
        private readonly ResourceRepositoryInterface $productRepository,
        private readonly ResourceRepositoryInterface $productRecommendationRepository,
        private readonly ClientProductUseCase $clientProductUseCase
    ){}

    /**
     * Generate a Product recommendation for a given Client, based on products available and Client
     * financial and personal information
     *
     * @param Client $client
     * @return ProductRecommendation|null
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

        if (count($scoresByProduct) > 1) {
            arsort($scoresByProduct, SORT_NUMERIC);
        }

        //If there are more than one compatible product, we have to choose the one of highest score in order
        // to give the best recommendation to the user

        $productId = array_key_first($scoresByProduct);

        // We have to check the case when all products scored 0, so any product will be eligible to recommend
        if($scoresByProduct[$productId] === 0) {
            return null;
        }

        foreach ($availableProducts as $product) {
            if($product->getId() === $productId) {
                $productRecommendation = new ProductRecommendation($client, $product);
                $this->productRecommendationRepository->saveAndFlush($productRecommendation);

                return $productRecommendation;
            }
        }

        return null;
    }

    /**
     * Accepts a Product Recommendation by its ID
     *
     * @param int $productRecommendationId
     * @return ProductRecommendation
     * @throws ResourceNotFoundException
     */
    public function acceptProductRecommendation(int $productRecommendationId): ProductRecommendation
    {
        /** @var ProductRecommendation $productRecommendation */
        $productRecommendation = $this->productRecommendationRepository->find($productRecommendationId);

        if (is_null($productRecommendation)) {
            throw new ResourceNotFoundException(new TranslatableMessage('loans.exceptions.useCase.productRecommendationNotFound'));
        }

        $productRecommendation->setStatus(ProductRecommendation::STATUS_ACCEPTED);

        // We only save changes on recommendation but don't make flush yet since the product and client association must be created
        $this->productRecommendationRepository->save($productRecommendation);

        // We have to create the new Product and Client association from the given recommendation

        $clientProduct = $this->clientProductUseCase->createNewFromRecommendation($productRecommendation);

        return $productRecommendation;
    }

    /**
     * Rejects a Product Recommendation by its ID
     *
     * @param int $productRecommendationId
     * @return ProductRecommendation
     * @throws ResourceNotFoundException
     */
    public function rejectProductRecommendation(int $productRecommendationId): ProductRecommendation
    {
        /** @var ProductRecommendation $productRecommendation */
        $productRecommendation = $this->productRecommendationRepository->find($productRecommendationId);

        if (is_null($productRecommendation)) {
            throw new ResourceNotFoundException(new TranslatableMessage('loans.exceptions.useCase.productRecommendationNotFound'));
        }

        $productRecommendation->setStatus(ProductRecommendation::STATUS_REJECTED);
        $this->productRecommendationRepository->saveAndFlush($productRecommendation);

        return $productRecommendation;
    }
}
