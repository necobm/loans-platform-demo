<?php

namespace App\Loans\Infrastructure\Controller;

use App\Loans\Domain\Model\ClientProduct;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ClientProduct::class;
    }
}
