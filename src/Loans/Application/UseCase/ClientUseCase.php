<?php

namespace App\Loans\Application\UseCase;

use App\Loans\Domain\Exception\InvalidFinancialPreferencesException;
use App\Loans\Domain\Model\Product;
use App\Loans\Domain\Model\ProductRecommendation;
use App\Loans\Domain\Model\Client;
use App\Loans\Domain\Repository\ResourceRepositoryInterface;
use Symfony\Component\Translation\TranslatableMessage;

class ClientUseCase
{
    public function __construct(
        private readonly ResourceRepositoryInterface $clientRepository
    ){}

    public function getClientByEmail(string $email): ?Client
    {
        $client = $this->clientRepository->findByCriteria(['email' => $email]);
        return $client[0] ?? null;
    }
}
