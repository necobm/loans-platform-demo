<?php

namespace App\Loans\Infrastructure\Controller;

use App\Loans\Domain\Model\ClientProduct;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\Translation\TranslatableMessage;

class ClientProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ClientProduct::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud->setPageTitle(Action::INDEX,new TranslatableMessage('loans.dashboardControllers.clientProductPageTitle'));
        return $crud;
    }
}
