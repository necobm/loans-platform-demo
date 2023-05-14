<?php

namespace App\Loans\Infrastructure\Controller;

use App\Loans\Domain\Model\Client;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Client::class;
    }
}
