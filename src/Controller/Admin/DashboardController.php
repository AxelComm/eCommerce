<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Entity\Commande;
use App\Entity\Commentaire;
use App\Entity\Paiement;
use App\Entity\Produit;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {


         return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()// nouvelles instances de Dashboard
            ->setTitle('ECommerce')//mettre le titre

        // pour mettre une icon sur votre page Admin
        // a mettre dans le head de dashboard.twig  <link rel="shortcut icon" href="{{ asset('favicon.svg') }}">
        ->setFaviconPath('img/headset-solid.svg')


        // utilisé pour definir la direction d'ecriture du texte
        ->setTextDirection('ltr');

    }

    public function configureMenuItems(): iterable
    {

// yield generer le l'item du menu
        yield MenuItem::section('Ecommerce', 'fa fa-home');

        yield MenuItem::section('Utilisateur', 'fas fa-user');
        yield MenuItem::subMenu('Action', 'fas fa-bars')
            ->setSubItems([                                                                                //mettre en action  l'action specifier en paramatre , PAGE_NEW = nouveau entity::class
                MenuItem::linkToCrud('Crée un utilisateur', 'fas fa-plus', User::class)->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Voir les utilisateurs', 'fas fa-eye', User::class),
            ]);


        yield MenuItem::section('Commentaire', 'fas fa-comment');
        yield MenuItem::subMenu('Action', 'fas fa-bars')
            ->setSubItems([
                MenuItem::linkToCrud('Crée un commentaire', 'fas fa-plus', Commentaire::class)->setAction(Crud::PAGE_NEW),
                 MenuItem::linkToCrud('Voir les commentaires', 'fas fa-eye', Commentaire::class),
            ]);

        yield MenuItem::section('Produit', 'fas fa-bag-shopping');
        yield MenuItem::subMenu('Action', 'fas fa-bars')
            ->setSubItems([
                MenuItem::linkToCrud('Crée un produit', 'fas fa-plus', Produit::class)->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Voir les produits', 'fas fa-eye', Produit::class),
            ]);

        yield MenuItem::section('Ctageorie', 'fas fa-filter');
        yield MenuItem::subMenu('Action', 'fas fa-bars')
            ->setSubItems([
                MenuItem::linkToCrud('Crée une categorie', 'fas fa-plus', Categorie::class)->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Voir les categories', 'fas fa-eye', Categorie::class),
            ]);

        yield MenuItem::section('Commande', 'fa-solid fa-file-circle-check');
        yield MenuItem::subMenu('Action', 'fas fa-bars')
            ->setSubItems([
                MenuItem::linkToCrud('Crée une commande', 'fas fa-plus', Commande::class)->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Voir les commandes', 'fas fa-eye', Commande::class),
            ]);

        yield MenuItem::section('Paiement', 'fa-solid fa-dollar-sign');
        yield MenuItem::subMenu('Action', 'fas fa-bars')
            ->setSubItems([
                MenuItem::linkToCrud('Crée une paiement', 'fas fa-plus', Paiement::class)->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Voir les paiements', 'fas fa-eye', Paiement::class),
            ]);

    }
}
