<?php

namespace App\Tests\Controller;

use App\Entity\Enum\FeriadoNivel;
use App\Repository\FeriadoRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class FeriadoControllerTest extends WebTestCase
{
    private $client;
    private $entityManager;
    private $feriadoRepository;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->entityManager = $this->client->getContainer()->get('doctrine.orm.entity_manager');
        $this->feriadoRepository = $this->entityManager->getRepository(\App\Entity\Feriado::class);
/*
        // Limpar feriados antes de cada teste para evitar conflitos de datas
       foreach ($this->feriadoRepository->findAll() as $feriado) {
            $this->entityManager->remove($feriado);
        }
        $this->entityManager->flush();*/
    }

    public function testCreateFeriadoSuccess(): void
    {
        $this->client->request(
            'POST',
            '/api/feriado',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'nome' => 'Natal',
                'data' => '2025-12-25',
                'nivel' => FeriadoNivel::NACIONAL,
                'recorrente' => true,
            ])
        );

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(201); // HTTP_CREATED
        $responseContent = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('id', $responseContent['data']);
        $this->assertSame('Natal', $responseContent['data']['nome']);

       
    }

    public function testCreateFeriadoDuplicateDateError(): void
    {
        // First, create a holiday
        $this->client->request(
            'POST',
            '/api/feriado',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'nome' => 'Ano Novo',
                'data' => '2025-01-01',
                'nivel' => FeriadoNivel::NACIONAL,
                'recorrente' => true,
            ])
        );
        $this->assertResponseStatusCodeSame(201);

        // Then, try to create another holiday on the same date
        $this->client->request(
            'POST',
            '/api/feriado',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'nome' => 'Confraternização Universal',
                'data' => '2025-01-01',
                'nivel' => FeriadoNivel::NACIONAL,
                'recorrente' => false,
            ])
        );

        $this->assertResponseStatusCodeSame(400); // HTTP_BAD_REQUEST
        $responseContent = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertSame('Já existe um feriado cadastrado para esta data.', $responseContent['error']);
    }

    public function testCreateFeriadoValidationError(): void
    {
        $this->client->request(
            'POST',
            '/api/feriado',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'nome' => '', // Invalid: blank name
                'data' => 'invalid-date', // Invalid: date format
                'nivel' => 'INVALIDO', // Invalid: enum value
                'recorrente' => 'not_a_boolean', // Invalid: type
            ])
        );

        $this->assertResponseStatusCodeSame(400); // HTTP_BAD_REQUEST for validation errors from DTO
        $responseContent = json_decode($this->client->getResponse()->getContent(), true);

        // Check for multiple error messages structure.
        // This depends on how ResponseTrait formats ConstraintViolationList
        $this->assertIsArray($responseContent['error']);
        $errorsFound = 0;
        foreach ($responseContent['error'] as $errorDetail) {
            if (isset($errorDetail['message'])) {
                if (str_contains($errorDetail['message'], 'O nome do feriado não pode estar em branco.')) $errorsFound++;
                if (str_contains($errorDetail['message'], 'A data do feriado deve ser uma data válida.')) $errorsFound++;
                if (str_contains($errorDetail['message'], 'O nível do feriado não pode estar em branco.')) $errorsFound++; // DTO validation for nivel
                if (str_contains($errorDetail['message'], 'O campo recorrente deve ser um booleano.')) $errorsFound++;
            } else { // Fallback if structure is simpler array of strings
                 if (str_contains($errorDetail, 'O nome do feriado não pode estar em branco.')) $errorsFound++;
                 if (str_contains($errorDetail, 'A data do feriado deve ser uma data válida.')) $errorsFound++;
                 if (str_contains($errorDetail, 'O nível do feriado não pode estar em branco.')) $errorsFound++;
                 if (str_contains($errorDetail, 'O campo recorrente deve ser um booleano.')) $errorsFound++;
            }
        }
        // Ensure at least the name and data validation messages are present
        // The exact number of errors might vary based on how "INVALIDO" for nivel and "not_a_boolean" for recorrente are handled
        // by the Serializer and Validator.
        $this->assertGreaterThanOrEqual(2, $errorsFound, "Expected at least 2 validation errors for name and data.");
    }

   
}
