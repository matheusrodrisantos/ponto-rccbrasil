<?php

namespace App\Controller;


use App\Dto\Feriado\FeriadoInputDTO;
use App\Dto\Feriado\FeriadoOutputDTO;
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
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

#[Route('/api')]
final class FeriadoController extends AbstractController
{
    use ResponseTrait;
    public function __construct(
        private readonly FeriadoService $feriadoService,
        private readonly SerializerInterface $serializer,
        private readonly NormalizerInterface $normalizer,
        private readonly ValidatorInterface $validator
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
        Request $request
    ): JsonResponse {
        try {

            $feriadoInputDto = $this->serializer->deserialize($request->getContent(), FeriadoInputDTO::class, 'json');

            $errors = $this->validator->validate($feriadoInputDto);
            if (count($errors) > 0) {
                $errorMessages = [];
                foreach ($errors as $error) {
                    $errorMessages[$error->getPropertyPath()][] = $error->getMessage();
                }
                return $this->createErrorResponse(json_encode($errorMessages), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            return $this->createSuccessResponse([
                
                $feriadoInputDto
            ], Response::HTTP_CREATED);
            //$feriadoOutput = $this->feriadoService->criarFeriado($feriadoInputDto);


            //$normalizedData = $this->normalizer->normalize($feriadoOutput);
            //return $this->createSuccessResponse($normalizedData, Response::HTTP_CREATED);
        } catch (RegraDeNegocioFeriadoException $e) {

            return $this->createErrorResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (NotEncodableValueException $e) {
            return $this->createErrorResponse('JSON malformatado: ' . $e->getMessage(), Response::HTTP_BAD_REQUEST);
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

            $normalizedData = $this->normalizer->normalize($feriado);
            return $this->createSuccessResponse($normalizedData);
        } catch (FeriadoNotFoundException $e) {

            return $this->createErrorResponse($e->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return $this->createErrorResponse('Erro ao processar a requisição: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
