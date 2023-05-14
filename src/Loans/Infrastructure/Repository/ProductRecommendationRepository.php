<?php

namespace App\Loans\Infrastructure\Repository;

use App\Loans\Domain\Model\ProductRecommendation;
use Symfony\Component\Translation\TranslatableMessage;

class ProductRecommendationRepository extends AbstractResourceRepository
{
    public function supportsResource(): void
    {
        if ($this->resourceFqcn !== ProductRecommendation::class) {
            throw new \LogicException(new TranslatableMessage('loans.exceptions.repository.invalidResource'));
        }
    }
}
