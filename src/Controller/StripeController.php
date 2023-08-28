<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Repository\ProduitRepository;

use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class StripeController extends AbstractController
{
    #[Route('/create-checkout-session/', name: 'app_stripeCheckout')]
    public function createCheckoutSession(SessionInterface $session, ProduitRepository $produitRepository): Response
    {
        Stripe::setApiKey('sk_test_51NjJrPHs9x2HMpxi67OKMwmu4ufkcmXoFu6UU8QEhUIAm4wLc4JTdIf5a5VCvbX8tT96TLtJ0DxRS0WlSEd9fOV600ySI41ehI');

        $YOUR_DOMAIN = 'http://127.0.0.1:8000';

        // Récupérez le contenu du panier depuis la session
        $panier = $session->get('panier', []);

        // Créez les items de ligne pour la session de paiement Stripe
        $dataPanier = [];
        foreach ($panier as $id => $quantity) {
            $produit = $produitRepository->find($id);

            if ($produit) {
                $dataPanier[] = [
                    'price_data' => [
                        'currency' => 'eur', // Remplacez par la devise appropriée
                        'unit_amount' => $produit->getPrix() * 100, // Convertissez le prix en centimes
                        'product_data' => [
                            'name' => $produit->getNom(),
                            'images' => [$YOUR_DOMAIN .'/public/img/' . $produit->getImage()], // Remplacez par l'URL de l'image du produit
                        ],
                    ],
                    'quantity' => $quantity,
                ];
            }
        }

        // Créez la session de paiement Stripe avec les éléments du panier
        $checkout_session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $dataPanier,
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN .'/commande/validation',
            'cancel_url' =>  $YOUR_DOMAIN .'/accueil',
        ]);

        // Redirigez vers la page de paiement Stripe
        return $this->redirect($checkout_session->url);
    }


}
