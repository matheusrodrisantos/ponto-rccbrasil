<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PontoController extends AbstractController
{
    #[Route('/ponto', name: 'app_ponto', methods:['GET'])]
    public function index(): Response
    {
        return $this->render('ponto/index.html.twig', [
            'controller_name' => 'PontoController',
        ]);
    }
}
