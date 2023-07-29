<?php

namespace App\Controller\Admin;

use App\Entity\Produit;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProduitCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Produit::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom'),
            BooleanField::new('stock'),
            NumberField::new('prix'),
            ImageField::new('image')
                ->setBasePath('img/') // Chemin pour l'affichage img
                ->setUploadDir('public/img/') // Répertoire d'upload
                ->setUploadedFileNamePattern('[randomhash].[extension]'), // Nom du fichier uploadé
            TextField::new('slug'),
            TextField::new('description'),
            TextField::new('marque'),
            TextField::new('materiau'),
            TextField::new('couleur'),
            TextField::new('dimensions'),
            TextField::new('poids'),
            TextField::new('assemblage'),
            AssociationField::new('categorie')
                ->setLabel('Catégorie')
                ->setFormTypeOption('query_builder', function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.nom', 'ASC');
                }),

        ];
    }

}
