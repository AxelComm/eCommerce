<?php

namespace App\Form;

use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,[
                'label' => 'Nom : '
            ])
            ->add('prenom', TextType::class,[
                'label' => 'Prenom : '
            ])
            ->add('pseudo', TextType::class,[
                'label' => 'Pseudo : '
            ])
            ->add('image', FileType::class, [
                'label' => 'Image de profil : ',
                'mapped' => false,
                'required' => false,
                // Autres options éventuelles
            ])
            ->add('naissance', DateType::class,[
                'label' => 'Date de naissance :'
            ])
            ->add('rue_adresse', TextType::class, [
                'label' => 'Nom de rue :'
            ])
            ->add('numero_adresse',TextType::class, [
                'label'=> 'Numero de rue :'
            ] )
            ->add('cp_adresse', TextType::class, [
                'label' => 'Code postal : '
            ])
            ->add('ville_adresse',TextType::class, [
                'label' => 'Ville :'
            ])
            ->add('pays_adresse', TextType::class, [
                'label' => 'Pays :'
            ])
            ->add('email', TextType::class,[
                'label' => 'Email : '
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => "Accords d'utilisation",
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => "Vous devez valider les accords d'utilisation.",
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label'=> 'Mot de passe :',
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // taille maximal pour des raisons de securité
                        'max' => 4096,
                    ]),
                ],
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
