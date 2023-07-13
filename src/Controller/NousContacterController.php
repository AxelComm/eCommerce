<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NousContacterController extends AbstractController
{
    #[Route('/nous/contacter', name: 'app_nous_contacter')]
    public function index(
    ): Response
    {
        return $this->render('nous_contacter/index.html.twig', [
            'controller_name' => 'NousContacterController',
        ]);
    }
}
