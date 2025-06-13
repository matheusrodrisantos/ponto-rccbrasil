<?php

namespace App\Controller;

// Updated use statements
use App\Dto\FeriadoInputDTO;
use App\Dto\FeriadoOutputDTO;
use App\Exception\FeriadoNotFoundException;
use App\Service\FeriadoService;
use App\Exception\RegraDeNegocioFeriadoException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload; // Import MapRequestPayload
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

#[Route('/api')] // Added a common prefix for API routes
final class FeriadoController extends AbstractController
{
    use ResponseTrait;
    public function __construct(
        private readonly FeriadoService $feriadoService,
        private readonly SerializerInterface $serializer,
        private readonly NormalizerInterface $normalizer,
        private readonly ValidatorInterface $validator // Added validator
    ) {}

    #[Route('/feriado', name: 'app_feriado_list', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Listagem de feriados (a implementar)',
            'path' => 'src/Controller/FeriadoController.php',
        ]);
    }

    #[Route('/feriado', name: 'app_feriado_create', methods: ['POST'])]
    public function create(
        Request $request // Using Request directly for now
    ): JsonResponse {
        try {
            // Deserialize to FeriadoInputDTO
            $feriadoInputDto = $this->serializer->deserialize($request->getContent(), FeriadoInputDTO::class, 'json');

            // Validate Input DTO
            $errors = $this->validator->validate($feriadoInputDto);
            if (count($errors) > 0) {
                $errorMessages = [];
                foreach ($errors as $error) {
                    $errorMessages[$error->getPropertyPath()][] = $error->getMessage();
                }
                return $this->createErrorResponse($errorMessages, Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            // Call service with InputDTO, expect OutputDTO or entity
            $feriadoOutput = $this->feriadoService->criarFeriado($feriadoInputDto);

            // Normalize the output (OutputDTO or entity)
            $normalizedData = $this->normalizer->normalize($feriadoOutput);
            return $this->createSuccessResponse($normalizedData, Response::HTTP_CREATED);

        } catch (RegraDeNegocioFeriadoException $e) {
            // Business logic errors: 400
            return $this->createErrorResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (NotEncodableValueException $e) {
            return $this->createErrorResponse('JSON malformatado: ' . $e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            // Other errors: 500
            return $this->createErrorResponse('Erro ao processar a requisição: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/feriado/{data}', name: 'app_feriado_get', methods: ['GET'])]
    public function getFeriado(
        string $data
    ): JsonResponse {
        try {
            $dataFeriado = new \DateTimeImmutable($data);
            // Assuming buscarFeriadoPorData returns an entity or FeriadoOutputDTO
            $feriado = $this->feriadoService->buscarFeriadoPorData($dataFeriado);

            // Normalize the output for consistency
            $normalizedData = $this->normalizer->normalize($feriado);
            return $this->createSuccessResponse($normalizedData);

        } catch (FeriadoNotFoundException $e) {
            // Specific not found exception: 404 would be more appropriate
            return $this->createErrorResponse($e->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return $this->createErrorResponse('Erro ao processar a requisição: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
