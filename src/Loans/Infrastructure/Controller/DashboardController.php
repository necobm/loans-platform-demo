<?php

namespace App\Loans\Infrastructure\Controller;

use App\Loans\Domain\Model\Product;
use App\Loans\Domain\Model\ProductType;
use App\Loans\Domain\Model\User;
use App\Loans\Domain\Model\UserProduct;
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
         return $this->redirect($this->adminUrlGenerator->setController(UserCrudController::class)->generateUrl());

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
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
            MenuItem::linkToCrud(new TranslatableMessage('loans.menuItem.mainMenu.loans'), 'fa fa-credit-card', UserProduct::class),
            MenuItem::linkToCrud(new TranslatableMessage('loans.menuItem.mainMenu.products'), 'fa fa-dollar', Product::class),
            MenuItem::linkToCrud(new TranslatableMessage('loans.menuItem.mainMenu.productTypes'), 'fa fa-box', ProductType::class),
            MenuItem::section(new TranslatableMessage('loans.menuItem.mainMenu.security')),
            MenuItem::linkToCrud(new TranslatableMessage('loans.menuItem.mainMenu.users'), 'fa fa-user', User::class)
        ];
    }
}
