<?php

namespace App\Controller;

use App\Dto\Departamento\DepartamentoInputDTO; 
use App\Dto\Departamento\DepartamentoOutputDTO;
use App\Dto\Departamento\DepartamentoUpdateDTO;

use App\Exception\RegraDeNegocioDepartamentoException;
use App\Service\DepartamentoService;
use App\Service\ResponseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface; // Added

#[Route('/api')]
final class DepartamentoController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private NormalizerInterface $normalizer,
        private ResponseService $responseService,
        private ValidatorInterface $validator // Added
    ) {}

    #[Route('/departamento', name: 'app_create_departamento', methods: ['POST'])]
    public function create(
        Request $request,
        DepartamentoService $departamentoService
    ): JsonResponse {
        try {
            $inputDto = $this->serializer->deserialize(
                $request->getContent(),
                DepartamentoInputDTO::class, 
                'json'
            );

            $errors = $this->validator->validate($inputDto);
            if (count($errors) > 0) {
                $errorMessages = [];
                foreach ($errors as $error) {
                    $errorMessages[$error->getPropertyPath()][] = $error->getMessage();
                }
                return $this->responseService->createErrorResponse(
                    json_encode($errorMessages), // Pass structured messages
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }

            $outputDto = $departamentoService->createEntity($inputDto);

            $dtoArray = $this->normalizer->normalize($outputDto);

            return $this->responseService->createSuccessResponse(
                $dtoArray,
                Response::HTTP_CREATED
            );
        } catch (RegraDeNegocioDepartamentoException $e) {
            return $this->responseService->createErrorResponse(
                $e->getMessage(),
                Response::HTTP_BAD_REQUEST
            );
        } catch (\Exception $e) {
            return $this->responseService->createErrorResponse($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    #[Route('departamento/{departamentoId}/supervisor/{supervisorId}', name: 'app_definir_supervisor_departamento', methods: ['PUT'])]
    public function definirSupervisor(
        int $departamentoId,
        int $supervisorId,
        DepartamentoService $departamentoService
    ): JsonResponse {
        try {

            $updateDto = new DepartamentoUpdateDTO(id: $departamentoId, supervisorId: $supervisorId);

            $departamentoService->definirSupervisor($updateDto);

            return $this->responseService->createSuccessResponse([], Response::HTTP_NO_CONTENT);
        } catch (RegraDeNegocioDepartamentoException $e) {
            return $this->responseService->createErrorResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return $this->responseService->createErrorResponse($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('departamento/{departamentoId}', name: 'app_get_departamento', methods: ['DELETE'])]
    public function removerSupervisor(
        int $departamentoId,
        DepartamentoService $departamentoService
    ): JsonResponse {
        try {
            $updateDto = new DepartamentoUpdateDTO(id: $departamentoId);

            $departamentoService->removerSupervisor($updateDto);

            return $this->responseService->createSuccessResponse([], Response::HTTP_NO_CONTENT);
        } catch (RegraDeNegocioDepartamentoException $e) {
            return $this->responseService->createErrorResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return $this->responseService->createErrorResponse($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('departamento', name: 'app_list_departamentos', methods: ['GET'])]
    public function listDepartamentos(
        DepartamentoService $departamentoService
    ): JsonResponse {
        try {
            $departamentos = $departamentoService->listarDepartamentos();

            $dtoArray = $this->normalizer->normalize($departamentos);

            return $this->responseService->createSuccessResponse($dtoArray, Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->responseService->createErrorResponse($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
