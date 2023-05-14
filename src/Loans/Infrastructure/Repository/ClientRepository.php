<?php

namespace App\Loans\Infrastructure\Repository;

use App\Loans\Domain\Model\Client;
use Symfony\Component\Translation\TranslatableMessage;

class ClientRepository extends AbstractResourceRepository
{
    public function supportsResource(): void
    {
        if ($this->resourceFqcn !== Client::class) {
            throw new \LogicException(new TranslatableMessage('loans.exceptions.repository.invalidResource'));
        }
    }
}
