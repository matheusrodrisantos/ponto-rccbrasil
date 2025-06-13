<?php

namespace App\Controller;

use App\Dto\FeriadoDTO;
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
        private readonly SerializerInterface $serializer, // Inject SerializerInterface
        private readonly NormalizerInterface $normalizer
    ) {}

    #[Route('/feriado', name: 'app_feriado_list', methods: ['GET'])] // Kept original route for listing, if needed later
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Listagem de feriados (a implementar)',
            'path' => 'src/Controller/FeriadoController.php',
        ]);
    }

    #[Route('/feriado', name: 'app_feriado_create', methods: ['POST'])]
    public function create(
        Request $request
    ): JsonResponse {
        try {

            $feriadoDTO = $this->serializer->deserialize($request->getContent(), FeriadoDTO::class, 'json');
            $feriado = $this->feriadoService->criarFeriado($feriadoDTO);

            return $this->createSuccessResponse($this->normalizer->normalize($feriado), Response::HTTP_CREATED);
        } catch (RegraDeNegocioFeriadoException $e) {
            return $this->createErrorResponse($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (NotEncodableValueException $e) {
            return $this->createErrorResponse('JSON malformatado: ' . $e->getMessage(),  Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return $this->createErrorResponse('Erro ao processar a requisição: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/feriado/{data}', name: 'app_feriado_get', methods: ['GET'])]
    public function getFeriado(
        string $data
    ): JsonResponse {
        try {
            $dataFeriado = new \DateTimeImmutable($data);
            $feriado = $this->feriadoService->buscarFeriadoPorData($dataFeriado);

            return $this->createSuccessResponse($this->normalizer->normalize(data: $feriado));
        } catch (FeriadoNotFoundException $e) {
            return $this->createErrorResponse($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return $this->createErrorResponse('Erro ao processar a requisição: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
