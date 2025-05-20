<?php

namespace App\Controller;

use App\Dto\FuncionarioDTO;
use App\Sevice\FuncionarioService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class FuncionarioController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
    ){}


    #[Route('/funcionario',name:'app_create_funcionario', methods:['POST'])]
    public function create(
        Request $request, 
        FuncionarioService $funcionarioService
    ): JsonResponse{

        try{
            
            $inputDto = $this->serializer->deserialize(
                $request->getContent(),
                 FuncionarioDTO::class,
                'json'
            );
            
            $outputFuncionarioDto=$funcionarioService->createEntity($inputDto);

            $json = $this->serializer->serialize($outputFuncionarioDto, 'json');
    
            return new JsonResponse($json,201,[],true);

        }catch(\Exception $e){
            return new JsonResponse(status:500, data: $e->getMessage());
        }   
        
    }


}
