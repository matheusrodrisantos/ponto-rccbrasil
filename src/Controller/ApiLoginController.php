<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

use App\Entity\Usuario;
use App\Sevice\ResponseService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\CurrentUser;


final class ApiLoginController extends AbstractController
{

    public function __construct(private ResponseService $responseService){}

    #[Route('/api/login', name: 'app_api_login', methods:['POST'])]
    public function index(#[CurrentUser] ?Usuario $user): ResponseService
    {
        if($user==null){

            return $this->responseService->createErrorResponse(
                "missing credentials", Response::HTTP_UNAUTHORIZED
            );
        }   

        return $this->responseService->createSuccessResponse(
            data:['message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ApiLoginController.php']);
    }
}
