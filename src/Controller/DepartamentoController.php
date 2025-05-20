<?php

namespace App\Controller;

use App\Dto\DepartamentoDTO;
use App\Sevice\DepartamentoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class DepartamentoController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
    ){}

    #[Route('/departamento', name: 'app_create_departamento', methods:['POST'])]
    public function create(
        Request $request,
        DepartamentoService $departamentoService
    ): JsonResponse
    {
        try{
            $inputDto = $this->serializer->deserialize(
                $request->getContent(),
                 DepartamentoDTO::class,
                'json'
            );
            
            $outputDepartamentoDto=$departamentoService->createEntity($inputDto);

            $json = $this->serializer->serialize($outputDepartamentoDto, 'json');
    
            return new JsonResponse($json,201,[],true);

        }catch(\Exception $e){
            return new JsonResponse(status:500, data: $e->getMessage());
        } 
    }
}
