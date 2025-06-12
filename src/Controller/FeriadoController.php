<?php

namespace App\Controller;

use App\Dto\FeriadoDTO;
use App\Service\FeriadoService;
use App\Exception\RegraDeNegocioFeriadoException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload; // Import MapRequestPayload

#[Route('/api')] // Added a common prefix for API routes
final class FeriadoController extends AbstractController
{
    use ResponseTrait;

    public function __construct(
        private readonly FeriadoService $feriadoService,
        private readonly SerializerInterface $serializer // Inject SerializerInterface
    ) {
    }
    
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
        Request $request, // Use Request to get content
        ValidatorInterface $validator
    ): JsonResponse {
        try {
            // Deserialize JSON to DTO
            $feriadoDTO = $this->serializer->deserialize($request->getContent(), FeriadoDTO::class, 'json');

            // Validate DTO
            $errors = $validator->validate($feriadoDTO);
            if (count($errors) > 0) {
                return $this->responseError($errors);
            }

            $feriado = $this->feriadoService->criarFeriado($feriadoDTO);
            // Assuming Feriado entity will have toArray(). If not, this needs adjustment.
            // For now, let's assume FeriadoDTO's toArray is sufficient if the created $feriado is returned from service
            // Or, better, the service returns the entity and we serialize it or convert to DTO then array.
            // For now, let's return the DTO's data, which is what we received, plus any generated ID if applicable.
            // The Feriado entity itself might be more appropriate to return after serialization.
            // Let's adjust to serialize the created Feriado entity.
            return $this->responseSuccess($this->serializer->normalize($feriado, null, ['groups' => 'feriado:read']), JsonResponse::HTTP_CREATED);


        } catch (RegraDeNegocioFeriadoException $e) {
            return $this->responseError($e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Symfony\Component\Serializer\Exception\NotEncodableValueException $e) {
            return $this->responseError('JSON malformatado: ' . $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            // Generic error for other unexpected issues
            return $this->responseError('Erro ao processar a requisição: ' . $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
