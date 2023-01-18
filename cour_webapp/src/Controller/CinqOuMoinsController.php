<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CinqOuMoinsController extends AbstractController
{
    #[Route('/cinq/ou/moins/{value}', name: 'app_cinq_ou_moins')]
    public function index($value): Response
    {
        if($value <= 5){
            $reponse = 'VRAI !';
        }else {
            $reponse = 'FAUX !';
        };
        return $this->render('cinq_ou_moins/index.html.twig', [
            'reponse' => $reponse
        ]);
    }
}
