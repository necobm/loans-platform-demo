<?php

namespace App\Loans\Infrastructure\Controller;

use App\Loans\Domain\Model\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Translation\TranslatableMessage;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', new TranslatableMessage('loans.formFieldLabel.product.name')),
            NumberField::new('interestRate', new TranslatableMessage('loans.formFieldLabel.product.interestRate')),
            NumberField::new('maxTerm', new TranslatableMessage('loans.formFieldLabel.product.maxTerm')),
            NumberField::new('maxAmount', new TranslatableMessage('loans.formFieldLabel.product.maxAmount')),
            NumberField::new('minimalIncomeRequirement', new TranslatableMessage('loans.formFieldLabel.product.minimalIncomeRequirement')),
            NumberField::new('adicionalCosts', new TranslatableMessage('loans.formFieldLabel.product.adicionalCosts')),
            AssociationField::new('type', new TranslatableMessage('loans.formFieldLabel.product.type'))
        ];
    }

}
