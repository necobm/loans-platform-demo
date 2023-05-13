<?php

namespace App\Loans\Domain\Repository;

interface ResourceRepositoryInterface
{
    public function find(int $id);
    public function findByCriteria(array $criteria);
    public function all();
    public function save($resource);
    public function saveAndFlush($resource);
    public function delete($resource);
}
