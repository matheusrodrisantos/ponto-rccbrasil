<?php

namespace App\Controller;

use App\Dto\FeriasDTO;

use App\Sevice\FeriasService;
use App\Sevice\ResponseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class FeriasController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private NormalizerInterface $normalizer,
        private ResponseService $responseService
    ){}

    #[Route('/ferias', name: 'app_create_ferias',methods:['POST'])]
    public function create(
        Request $request,
        FeriasService $feriasService
    ): ResponseService
    {
       try{
            $inputDto = $this->serializer->deserialize(
                $request->getContent(),
                FeriasDTO::class,
                'json'
            );
            
            $outputFeriasDto = $feriasService->createEntity($inputDto);
        
            $dtoArray=$this->normalizer->normalize($outputFeriasDto);

            return $this->responseService->createSuccessResponse(
                $dtoArray,
                Response::HTTP_CREATED
            );

        } catch (\Exception $e) {
            return $this->responseService->createErrorResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/ferias/{id}', name: 'app_update_ferias',methods:['PUT'])]
    public function update(
        Request $request,
        FeriasService $feriasService
    )//: JsonResponse
    {
       try{

            print_r($request->getContent());

 

        } catch (\Exception $e) {
            return $this->responseService->createErrorResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/ferias/{id}', name: 'app_delete_ferias',methods:['DELETE'])]
    public function delete(
        Request $request,
        FeriasService $feriasService
    ): ResponseService
    {
       try{
            $inputDto = $this->serializer->deserialize(
                $request->getContent(),
                FeriasDTO::class,
                'json'
            );
            
            $outputFeriasDto = $feriasService->createEntity($inputDto);
        
            $dtoArray=$this->normalizer->normalize($outputFeriasDto);

            return $this->responseService->createSuccessResponse(
                $dtoArray,
                Response::HTTP_OK
            );

        } catch (\Exception $e) {
            return $this->responseService->createErrorResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/ferias/{id}', name: 'app_delete_ferias',methods:['DELETE'])]
    public function list(
        Request $request,
        FeriasService $feriasService
    ): ResponseService
    {
       try{
            $inputDto = $this->serializer->deserialize(
                $request->getContent(),
                FeriasDTO::class,
                'json'
            );
            
            $outputFeriasDto = $feriasService->createEntity($inputDto);
        
            $dtoArray=$this->normalizer->normalize($outputFeriasDto);

            return $this->responseService->createSuccessResponse(
                $dtoArray,
                Response::HTTP_OK
            );

        } catch (\Exception $e) {
            return $this->responseService->createErrorResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
