<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'titre' => 'Bienvenue sur la page d’accueil.',
        ]);
    }
    #[Route('/home/{name}', name: 'app_home_name')]
    public function index2($name): Response
    {
        return $this->render('home/index.html.twig', [
            'titre' => 'Bienvenue sur la page d’accueil '.$name.'.',
        ]);
    }
}
