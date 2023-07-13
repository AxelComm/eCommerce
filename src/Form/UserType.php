<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'label' => 'Email :'
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom :'
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom :'
            ])
            ->add('pseudo', TextType::class, [
                'label' => 'Pseudo :'
            ])
            ->add('naissance', DateType::class, [
                'label' => 'Date de naissance :'
            ])
            ->add('numero_adresse', TextType::class, [
                'label' => 'Numéro :'
            ])
            ->add('rue_adresse', TextType::class, [
                'label' => 'Rue :'
            ])
            ->add('cp_adresse', TextType::class, [
                'label' => 'Code postal :'
            ])
            ->add('ville_adresse', TextType::class, [
                'label' => 'Ville :'
            ])
            ->add('pays_adresse', TextType::class, [
                'label' => 'Pays :'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
