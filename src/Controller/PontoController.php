<?php

namespace App\Controller;

use App\Dto\RegistroPontoDTO;
use App\Service\RegistroPontoService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class PontoController extends AbstractController
{
    use ResponseTrait;
    public function __construct(
        private SerializerInterface $serializer,
        private NormalizerInterface $normalizer,
        private RegistroPontoService $registroPontoService
    ){}

    #[Route('/ponto', name: 'app_ponto', methods:['GET'])]
    public function index(): Response
    {
        return $this->render('ponto/index.html.twig', [
            'controller_name' => 'PontoController',
        ]);
    }

    #[Route('api/ponto', name: 'app_create_ponto', methods:['POST'])]
    public function registrar(Request $request):JsonResponse
    {
        try{
            $pontoDto= $this->serializer->deserialize(
                data:$request->getContent(),
                type:RegistroPontoDTO::class,
                format:'json'
            );

            $this->registroPontoService->registrar($pontoDto->funcionarioId);


            $dtoArray=$this->normalizer->normalize($pontoDto);

            return $this->createSuccessResponse(
                $dtoArray,
                Response::HTTP_CREATED
            );


        }catch(\Exception $e){
            return $this->createErrorResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);   
        }
    }
}
