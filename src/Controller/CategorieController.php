<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Commentaire;
use App\Repository\CommentaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


#[Route('/categories')]
class CategorieController extends AbstractController
{
    #[Route('/{nom}', name: 'app_categorie')]
    public function index(
        Categorie $categorie,
        Request $request,//objet qui represente la requete http qui contient toutes les informations envoyées
        EntityManagerInterface $entityManager,
        CommentaireRepository $commentaireRepository
    ): Response
    {
        $commentaire = new Commentaire();// on cree une nouvelles instance de Commentaire
        $formCommentaire = $this->createForm('App\Form\CommentaireType', $commentaire); // on cree le form a partir de CommentaireType
        $formCommentaire->handleRequest($request);//methode qui traite le formulaire

        if ($formCommentaire->isSubmitted() && $formCommentaire->isValid()){
            $commentaire->setUser($this->getUser()); // Définir l'utilisateur connecté comme l'auteur du commentaire
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_shop');
        }

        $commentaires = $commentaireRepository->findAll();

        return $this->render('categorie/index.html.twig',[
            'categorie' => $categorie,
            'commentaires'=> $commentaires,
            'formCommentaire'=> $formCommentaire
        ]);
    }


    #[Route('/commentaire/delete{id}', name: 'delete_categories_commentaire')]
    public function deleteCommentaire(
        Request $request,
        CommentaireRepository $commentaireRepository,
        EntityManagerInterface $entityManager,
        Commentaire $id,
        Security $security

    ): Response
    {

        $commentaire = $commentaireRepository->find($id);

        if (!$commentaire) {
            throw $this->createNotFoundException('Commentaires not found.');
        }

        $user = $this->getUser();//recupere le user connecté

        //on utilise security pour l'autorisation a supprimer e commentaire ou non
        if (!$security->isGranted('ROLE_ADMIN') || $commentaire->getUser() !== $user){
            $this->addFlash('warning',"Vous n'etes pas autoriser a supprimer ce commentaire");
            return $this->redirectToRoute('app_shop');
        }
        // jeton de securite qui verifie que l'action ce fait bien apr le formulaire
        if ($this->isCsrfTokenValid('delete' . $commentaire->getId(), $request->request->get('token'))) {
            $entityManager->remove($commentaire);
            $entityManager->flush();
        }


        return $this->redirectToRoute('app_shop');


    }
}
