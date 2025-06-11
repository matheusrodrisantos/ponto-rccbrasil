<?php

namespace App\Controller;

use App\Dto\FuncionarioDTO;
use App\Service\FuncionarioService;
use App\Service\ResponseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class FuncionarioController extends AbstractController
{
    use ResponseTrait;
    public function __construct(
        private SerializerInterface $serializer,
        private NormalizerInterface $normalizer,
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

            return $this->createSuccessResponse(
                $dtoArray,
                Response::HTTP_CREATED
            );

        }catch(\Exception $e){
            return $this->createErrorResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }   
        
    }

    #[Route('api/funcionario/{id}/perfil-completo', name:"app_detalhes_funcionario", methods:['GET'])]
    public function detalheFuncionario(int $id):JsonResponse{

        try{
            $detalheFuncionarioDto=$this->funcionarioService->detalhe($id);
        
            $dtoArray=$this->normalizer->normalize($detalheFuncionarioDto);

            return $this->createSuccessResponse($dtoArray);

        }catch(NotFoundHttpException $n){
            return $this->createErrorResponse($n->getMessage(), Response::HTTP_BAD_REQUEST);
        }   
        
    }
}
