<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UtilisateurController extends AbstractController
{
    #[Route('/utilisateur', name: 'app_utilisateur')]
    public function index(): Response
    {   
        $users = [
            ['nom'=>'Lockheart','prenom'=>'Skoll'],
            ['nom'=>'Serathia','prenom'=>'Ayslinn'],
            ['nom'=>'Admin','prenom'=>'User']
        ];
        return $this->render('utilisateur/index.html.twig', [
            'compte' => $users,
        ]);
    }
}
