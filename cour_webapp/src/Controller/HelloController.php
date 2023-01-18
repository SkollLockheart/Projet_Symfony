<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    #[Route('/hello/{value}', name: 'app_hello')]
    public function index($value): Response
    {
        return $this->render('hello/index.html.twig', [
            'contenu' => $value,
        ]);
    }
}
