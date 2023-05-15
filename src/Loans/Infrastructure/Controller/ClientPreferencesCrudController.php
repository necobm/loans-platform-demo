<?php

namespace App\Loans\Infrastructure\Controller;

use App\Loans\Domain\Model\Client;
use App\Loans\Domain\Model\ClientFinancialPreferences;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Translation\TranslatableMessage;

#[IsGranted('ROLE_USER')]
class ClientPreferencesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ClientFinancialPreferences::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud->setPageTitle(Action::INDEX,new TranslatableMessage('loans.dashboardControllers.clientPreferenceTitle'));
        $crud->setEntityPermission('OWNER_VIEW');
        return $crud;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            NumberField::new('loanAmount', new TranslatableMessage('loans.formFieldLabel.clientPreferences.loanAmount')),
            NumberField::new('maxTerm', new TranslatableMessage('loans.formFieldLabel.clientPreferences.maxTerm')),
            AssociationField::new('productType', new TranslatableMessage('loans.formFieldLabel.clientPreferences.productType'))
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return parent::configureActions($actions)
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->remove(Crud::PAGE_INDEX, Action::NEW);
    }
}
