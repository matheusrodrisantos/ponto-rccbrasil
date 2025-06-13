<?php

namespace App\Controller;

use App\Dto\DepartamentoInputDTO; // Changed
use App\Dto\DepartamentoOutputDTO; // Added
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
                DepartamentoInputDTO::class, // Changed
                'json'
            );

            $errors = $this->validator->validate($inputDto);
            if (count($errors) > 0) {
                $errorMessages = [];
                foreach ($errors as $error) {
                    // Use getPropertyPath() for field name, getMessage() for the error
                    $errorMessages[$error->getPropertyPath()][] = $error->getMessage();
                }
                return $this->responseService->createErrorResponse(
                    $errorMessages, // Pass structured messages
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }

            // Assuming $departamentoService->createEntity will now accept DepartamentoInputDTO
            // and return either a Departamento entity or a DepartamentoOutputDTO.
            $outputDto = $departamentoService->createEntity($inputDto);

            // If $outputDto is an entity, it needs to be mapped to DepartamentoOutputDTO
            // or the service should return DepartamentoOutputDTO directly.
            // For now, let's assume the service returns an entity and we normalize it.
            // If the service is updated to return DepartamentoOutputDTO, this normalization
            // will also work. The key is that the structure matches what the frontend expects.

            $dtoArray = $this->normalizer->normalize($outputDto); // Normalizing the output

            return $this->responseService->createSuccessResponse(
                $dtoArray,
                Response::HTTP_CREATED
            );
        } catch (RegraDeNegocioDepartamentoException $e) {
            return $this->responseService->createErrorResponse(
                $e->getMessage(),
                Response::HTTP_BAD_REQUEST // Changed to BAD_REQUEST for business logic errors as per original,
                                          // to differentiate from validation's UNPROCESSABLE_ENTITY
            );
        } catch (\Exception $e) {
            // Catching generic \Exception should be more specific if possible,
            // but for now, keeping it as is.
            return $this->responseService->createErrorResponse($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
