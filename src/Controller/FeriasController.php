<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FeriasController extends AbstractController
{
    #[Route('/ferias', name: 'app_ferias')]
    public function index(): Response
    {
        return $this->render('ferias/index.html.twig', [
            'controller_name' => 'FeriasController',
        ]);
    }
}
