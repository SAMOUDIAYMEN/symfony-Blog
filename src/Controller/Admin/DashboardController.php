<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Media;
use App\Entity\Menu;
use App\Entity\Option;
use App\Entity\Page;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator){
        
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator->setController(ArticleCrudController::class)->generateUrl();

        return $this->redirect($url);

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Blog Dashboard')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Aller sur le site', 'fas fa-undo', 'app_home');

        if($this->isGranted('ROLE_ADMIN')){
            yield MenuItem::linkToCrud('Menus', 'fas fa-list',Menu::class);
            // ->setSubItems([
            //     MenuItem::linkToCrud('Pages', 'fas fa-file', Menu::class),
            //     MenuItem::linkToCrud('Articles', 'fas fa-newspaper', Menu::class),
            //     MenuItem::linkToCrud('Liens personnalisés', 'fas fa-link', Menu::class),
            //     MenuItem::linkToCrud('Catégories', 'fab fa-delicious', Menu::class),
            // ]);
        }
        
        if($this->isGranted('ROLE_AUTHOR')){
            yield MenuItem::subMenu('Articles', 'fas fa-newspaper')->setSubItems([
                MenuItem::linkToCrud('Tous les articles', 'fas fa-newspaper', Article::class),
                MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Article::class)->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Catégories', 'fas fa-list', Category::class)
            ]);

            yield MenuItem::subMenu('Médias', 'fas fa-photo-video')->setSubItems([
                MenuItem::linkToCrud('Médiathèque', 'fas fa-photo-video', Media::class),
                MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Media::class)->setAction(Crud::PAGE_NEW),
            ]);

            yield MenuItem::subMenu('Pages', 'fas fa-file')->setSubItems([
                MenuItem::linkToCrud('Toutes les pages', 'fas fa-file', Page::class),
                MenuItem::linkToCrud('Ajouter une page', 'fas fa-plus', Page::class)->setAction(Crud::PAGE_NEW)
            ]);
            yield MenuItem::linkToCrud('Commentaires', 'fas fa-comment', Comment::class);

        }

        if($this->isGranted('ROLE_ADMIN')){
            yield MenuItem::subMenu('Comptes', 'fas fa-user')->setSubItems([
                MenuItem::linkToCrud('Tous les comptes', 'fas fa-user-friends ', User::class),
                MenuItem::linkToCrud('Ajouter', 'fas fa-plus', User::class)->setAction(Crud::PAGE_NEW),
            ]);
    
            yield MenuItem::subMenu('Réglages', 'fas fa-cog')->setSubItems([
                MenuItem::linkToCrud('Général', 'fas fa-cog', Option::class),
            ]);

        }
        
    }
}
