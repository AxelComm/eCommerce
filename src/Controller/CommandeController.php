<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Repository\ProduitRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    #[Route('/commande/verif', name: 'app_commande')]
    public function index(
        SessionInterface $session,
        ProduitRepository $produitRepository,
        UserRepository $userRepository,

    ): Response
    {

        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }else{
            $user = $userRepository->find($this->getUser());
            $panier = $session->get('panier',[]);

            $panierWithData = [];
            foreach ($panier as $id => $quantity){

                $panierWithData[] = [
                    'produit' => $produitRepository->find($id),
                    'quantity' => $quantity
                ];
            }

            $total =0;

            foreach ($panierWithData as $item){
                $totalItem = $item['produit']->getPrix() * $item['quantity'];
                $total += $totalItem;
            }
        }

        $commande = new Commande();

        return $this->render('commande/index.html.twig', [
            'user'=> $user,
            'items' => $panierWithData,
            'total' =>$total
        ]);
    }




}


