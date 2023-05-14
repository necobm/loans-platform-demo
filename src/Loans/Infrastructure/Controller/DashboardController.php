<?php

namespace App\Loans\Infrastructure\Controller;

use App\Loans\Domain\Model\Product;
use App\Loans\Domain\Model\ProductType;
use App\Loans\Domain\Model\Client;
use App\Loans\Domain\Model\ClientProduct;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatableMessage;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private readonly AdminUrlGenerator $adminUrlGenerator
    ){}

    #[Route('/loans', name: 'loans')]
    public function index(): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirect($this->adminUrlGenerator->setController(ProductCrudController::class)->generateUrl());
        }

        return $this->redirect($this->adminUrlGenerator->setController(ClientProductCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('App');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

            MenuItem::section(new TranslatableMessage('loans.menuItem.mainMenu.products')),
            MenuItem::linkToCrud(new TranslatableMessage('loans.menuItem.mainMenu.loans'), 'fa fa-credit-card', ClientProduct::class),
            MenuItem::linkToRoute(new TranslatableMessage('loans.menuItem.mainMenu.newLoan'), 'fa fa-money', 'recommendations_get'),
            MenuItem::section(new TranslatableMessage('loans.menuItem.mainMenu.settings'))->setPermission('ROLE_ADMIN'),
            MenuItem::linkToCrud(new TranslatableMessage('loans.menuItem.mainMenu.products'), 'fa fa-dollar', Product::class)->setPermission('ROLE_ADMIN'),
            MenuItem::linkToCrud(new TranslatableMessage('loans.menuItem.mainMenu.productTypes'), 'fa fa-box', ProductType::class)->setPermission('ROLE_ADMIN'),
            MenuItem::linkToCrud(new TranslatableMessage('loans.menuItem.mainMenu.clients'), 'fa fa-user', Client::class)->setPermission('ROLE_ADMIN')
        ];
    }
}
