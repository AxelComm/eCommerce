<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;


class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {

        return User::class;
    }



    public function configureFields(string $pageName): iterable
    {
        return [
            //type de champ(Field)
            IdField::new('id')->hideOnForm(),
            TextField::new('email'),
            ArrayField::new('roles'),
            TextField::new('password',)
                ->hideOnForm()
                ->hideOnIndex(), // Pour masquer le champ dans la liste des utilisateurs

            TextField::new('nom'),
            TextField::new('prenom'),
            TextField::new('pseudo'),
            DateTimeField::new('naissance'),
            TextField::new('numero_adresse')->hideOnIndex(),
            TextField::new('rue_adresse')->hideOnIndex(),
            TextField::new('cp_adresse')->hideOnIndex(),
            TextField::new('ville_adresse')->hideOnIndex(),
            TextField::new('pays_adresse')->hideOnIndex(),
            ImageField::new('image')
                ->setBasePath('uploadImages/') // Chemin pour l'affichage img
                ->setUploadDir('public/uploadImages/') // Chemin pour le répertoire d'upload
                ->setUploadedFileNamePattern('[randomhash].[extension]'), // Nom du fichier uploadé

        ];
    }

}
