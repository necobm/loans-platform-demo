<?php

namespace App\Loans\Infrastructure\Repository;

use App\Loans\Domain\Repository\ResourceRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Translation\TranslatableMessage;

abstract class AbstractResourceRepository implements ResourceRepositoryInterface
{
    protected string $resourceFqcn;
    protected EntityManagerInterface $entityManager;

    public function __construct(
        string $resourceFqcn,
        EntityManagerInterface $entityManager
    )
    {
        $this->resourceFqcn = $resourceFqcn;
        $this->entityManager = $entityManager;
    }

    /**
     * Find one resources given its ID
     *
     * @param int $id
     * @return object|null
     */
    public function find(int $id): ?object
    {
        $this->supportsResource();
        return $this->entityManager->find($this->resourceFqcn, $id);
    }

    /**
     * Find all resources from database given a search criteria
     *
     * @param array $criteria
     * @return array
     * @throws \Exception
     */
    public function findByCriteria(array $criteria): array
    {
        $this->supportsResource();
        if (empty($criteria)) {
            throw new \Exception(new TranslatableMessage('loans.exceptions.repository.emptySearchCriteria'));
        }
        return $this->entityManager->getRepository($this->resourceFqcn)->findBy($criteria);
    }

    /**
     * Find all resources from database
     *
     * @return array
     */
    public function all(): array
    {
        $this->supportsResource();
        return $this->entityManager->getRepository($this->resourceFqcn)->findAll();
    }

    /**
     * Save changes to given resources or create a new one if it not exists
     *
     * @param $resource
     * @return void
     */
    public function save($resource): void
    {
        $this->supportsResource();
        if (get_class($resource) !== $this->resourceFqcn) {
            throw new \LogicException(new TranslatableMessage('loans.exceptions.repository.invalidResource'));
        }
        $this->entityManager->persist($resource);
    }

    /**
     * Save changes for the given resources and then commit the transaction to the database
     *
     * @param $resource
     * @return void
     */
    public function saveAndFlush($resource): void
    {
        $this->save($resource);
        $this->entityManager->flush();
    }

    /**
     * Deletes the given resource
     *
     * @param $resource
     * @return void
     */
    public function delete($resource): void
    {
        $this->supportsResource();
        if (get_class($resource) !== $this->resourceFqcn) {
            throw new \LogicException(new TranslatableMessage('loans.exceptions.repository.invalidResource'));
        }
        $this->entityManager->remove($resource);
    }
    public abstract function supportsResource(): void;
}
