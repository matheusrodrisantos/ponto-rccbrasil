<?php

namespace App\Controller;

use App\Dto\FeriasDTO;
use App\Sevice\FeriasService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class FeriasController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
    ){}


    #[Route('/ferias', name: 'app_create_ferias',methods:['POST'])]
    public function create(
        Request $request,
        FeriasService $feriasService
    ): JsonResponse
    {
        print_r($request->getContent());
        $inputDto = $this->serializer->deserialize(
            $request->getContent(),
             FeriasDTO::class,
            'json'
        );

        
        $json = $this->serializer->serialize($inputDto, 'json');

        return new JsonResponse(
            data: $json,
            status:201,
            json:true
        );
    }
}
