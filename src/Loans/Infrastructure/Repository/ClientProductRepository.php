<?php

namespace App\Loans\Infrastructure\Repository;

use App\Loans\Domain\Model\ClientProduct;
use Symfony\Component\Translation\TranslatableMessage;

class ClientProductRepository extends AbstractResourceRepository
{
    public function supportsResource(): void
    {
        if ($this->resourceFqcn !== ClientProduct::class) {
            throw new \LogicException(new TranslatableMessage('loans.exceptions.repository.invalidResource'));
        }
    }
}
