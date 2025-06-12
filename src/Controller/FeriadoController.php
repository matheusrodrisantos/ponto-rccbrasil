<?php

namespace App\Controller;

use App\Dto\FeriadoDTO;
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
        // This is just a placeholder, actual listing logic would be needed here
        return $this->json([
            'message' => 'Listagem de feriados (a implementar)',
            'path' => 'src/Controller/FeriadoController.php',
        ]);
    }

    #[Route('/feriado', name: 'app_feriado_create', methods: ['POST'])]
    public function create(
        Request $request, 
        ValidatorInterface $validator
    ): JsonResponse {
        try {
            
            $feriadoDTO = $this->serializer->deserialize($request->getContent(), FeriadoDTO::class, 'json');
            // Validate DTO
            $errors = $validator->validate($feriadoDTO);
            if (count($errors) > 0) {
                return $this->createErrorResponse(json_encode($errors), Response::HTTP_BAD_REQUEST);
            }

            $feriado = $this->feriadoService->criarFeriado($feriadoDTO);
            return $this->createSuccessResponse($this->normalizer->normalize($feriado, null, ['groups' => 'feriado:read']), Response::HTTP_CREATED);
        } catch (RegraDeNegocioFeriadoException $e) {
            return $this->createErrorResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (\Symfony\Component\Serializer\Exception\NotEncodableValueException $e) {
            return $this->createErrorResponse('JSON malformatado: ' . $e->getMessage(),  Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            // Generic error for other unexpected issues
            return $this->createErrorResponse('Erro ao processar a requisição: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
