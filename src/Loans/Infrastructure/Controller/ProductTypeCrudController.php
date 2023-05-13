<?php

namespace App\Loans\Infrastructure\Controller;

use App\Loans\Domain\Model\ProductType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Translation\TranslatableMessage;

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

}
