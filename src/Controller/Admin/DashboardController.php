<?php

namespace App\Controller\Admin;

use App\Entity\Annonce;
use App\Entity\Candidat;
use App\Entity\Postulant;
use App\Entity\Recruteur;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    
    #[Security("is_granted('ROLE_SUPER_ADMIN')", statusCode: 404)]
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());

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
            ->setTitle('HotelJobs');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard - User', 'fa fa-home');
        yield MenuItem::linkToCrud('Annonce', 'fas fa-list', Annonce::class);
        yield MenuItem::linkToCrud('Candidat', 'fas fa-list', Candidat::class);
        yield MenuItem::linkToCrud('Postulant', 'fas fa-list', Postulant::class);
        yield MenuItem::linkToCrud('Recruteur', 'fas fa-list', Recruteur::class);
    }

    public function configureAssets(): Assets
    {
        return Assets::new()->addCssFile('css/admin.css');
    }
}
