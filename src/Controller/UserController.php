<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController extends AbstractController
{
    #[Route('/user/visualiser', name: 'visualiser_user')]
    public function Visualiser(
        UserInterface  $user,
        UserRepository $userRepository
    ): Response
    {
        $id = $user->getId();
        $infoUser = $userRepository->find($id);


        return $this->render('user/index.html.twig', [
            'infoUser' => $infoUser

        ]);
    }


    #[Route('/user/modifier', name: 'modifier_user')]
    public function Modifier(
        Request                $request,
        EntityManagerInterface $en,
        UserInterface          $user,
        UserRepository         $userRepository,
    ): Response
    {
        $id = $user->getId();
        $user = $userRepository->find($id);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $en->persist($user);
            $en->flush();
            $this->addFlash('message', 'modification effectuée avec succés');

            return $this->redirectToRoute('visualiser_user');
        }


        return $this->render('user/modifierUser.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/user/delete', name: 'delete_user')]
    public function delete(
        Request                $request,
        EntityManagerInterface $entityManager,
        UserRepository         $userRepository,
        User $user
    ): Response
    {
        // Vérifie si l'utilisateur existe
        if (!$user){
        return $this->redirectToRoute('app_accueil');
        }

        // Vérifie la validité du jeton CSRF
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('token'))) {
            // Supprimer l'utilisateur
            $entityManager->remove($user);
            $entityManager->flush();
            // Vérifie si l'utilisateur supprimé est l'utilisateur actuellement authentifié
            if ($user === $this->getUser()){
                // Invalide la session de l'utilisateur actuellement authentifié
                $session = new Session();
                $session->invalidate();
            }
        }

        return $this->redirectToRoute('app_accueil');
    }







}
