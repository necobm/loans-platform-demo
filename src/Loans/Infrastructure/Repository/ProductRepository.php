<?php

namespace App\Loans\Infrastructure\Repository;

use App\Loans\Domain\Model\Product;
use Symfony\Component\Translation\TranslatableMessage;

class ProductRepository extends AbstractResourceRepository
{
    public function supportsResource(): void
    {
        if ($this->resourceFqcn !== Product::class) {
            throw new \LogicException(new TranslatableMessage('loans.exceptions.repository.invalidResource'));
        }
    }
}
