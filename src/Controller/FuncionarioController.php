<?php

namespace App\Controller;

use App\Dto\FuncionarioDTO;
use App\Sevice\FuncionarioService;
use App\Sevice\ResponseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class FuncionarioController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private NormalizerInterface $normalizer,
        private ResponseService $responseService,
        private FuncionarioService $funcionarioService
    ){}

    #[Route('api/funcionario',name:'app_create_funcionario', methods:['POST'])]
    public function create(
        Request $request
    ): JsonResponse{
        try{
            $inputDto = $this->serializer->deserialize(
                $request->getContent(),
                 FuncionarioDTO::class,
                'json');
            
            $outputFuncionarioDto=$this->funcionarioService->createEntity($inputDto);

            $dtoArray=$this->normalizer->normalize($outputFuncionarioDto);

            return $this->responseService->createSuccessResponse(
                $dtoArray,
                Response::HTTP_CREATED
            );

        }catch(\Exception $e){
            return $this->responseService->createErrorResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }   
        
    }

    #[Route('api/funcionario/{id}/ferias',name:'app_ferias_funcionario', methods:['GET'])]
    public function listarFeriasFuncionario(
        int $id
    )//: JsonResponse
    {
        try{
            
            $this->funcionarioService->listarFeriasFuncionario($id);

        }
        catch(\Exception $e){

        }

        /*
        try{
            $inputDto = $this->serializer->deserialize(
                $request->getContent(),
                 FuncionarioDTO::class,
                'json');
            
            $outputFuncionarioDto=$funcionarioService->createEntity($inputDto);

            $dtoArray=$this->normalizer->normalize($outputFuncionarioDto);

            return $this->responseService->createSuccessResponse(
                $dtoArray,
                Response::HTTP_OK
            );

        }catch(\Exception $e){
            return $this->responseService->createErrorResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }  */ 
    }

    #[Route('api/funcionario/{id}/perfil-completo', name:"app_detalhes_funcionario", methods:['GET'])]
    public function detalheFuncionario(int $id):JsonResponse{

        $detalheFuncionarioDto=$this->funcionarioService->detalhe($id);
        
        $dtoArray=$this->normalizer->normalize($detalheFuncionarioDto);

        return $this->responseService->createSuccessResponse($dtoArray);
    }
}
