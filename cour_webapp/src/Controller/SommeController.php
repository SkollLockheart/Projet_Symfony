<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SommeController extends AbstractController
{
    #[Route('/somme/{num1}+{num2}', name: 'app_somme')]
    public function index($num1,$num2): Response
    {
        return $this->render('somme/index.html.twig', [
            'resultat' => $num1+$num2,
        ]);
    }
}
