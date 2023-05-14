<?php

namespace App\Loans\Infrastructure\Controller;

use App\Loans\Domain\Model\ProductType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Translation\TranslatableMessage;

#[IsGranted('ROLE_ADMIN')]
class ProductTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductType::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', new TranslatableMessage('loans.formFieldLabel.productType.name')),
            NumberField::new('value', new TranslatableMessage('loans.formFieldLabel.productType.value'))
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud->setPageTitle(Action::INDEX,new TranslatableMessage('loans.dashboardControllers.productTypePageTitle'));
        return $crud;
    }

}
