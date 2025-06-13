<?php

namespace App\Tests\Controller;


use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Faker\Factory;

final class FeriasControllerTest extends WebTestCase
{

    public function test_falha_criar_ferias_menos_cinco_dias()
    {

        $dataIni = new DateTimeImmutable('+5 day');
        $dataFim = new DateTimeImmutable('+8 day');

        $dataIni = $dataIni->format('Y-m-d');
        $dataFim = $dataFim->format('Y-m-d');

        $funcionarioId = 1;
        $userInclusaoId = 2;


        $payload = [
            "funcionarioId" => $funcionarioId,
            "dataInicio" => $dataIni,
            "dataFim" => $dataFim,
            "userInclusaoId" => $userInclusaoId
        ];

        $client = static::createClient();
        $client->request(
            method: 'POST',
            uri: '/ferias',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($payload)
        );


        $response = $client->getResponse()->getContent();

        $this->assertResponseStatusCodeSame(400);
        $this->assertJson($response);
    }

    public function test_supervisor_diferente()
    {


        $dataIni = new DateTimeImmutable('+5 day');
        $dataFim = new DateTimeImmutable('+8 day');

        $dataIni = $dataIni->format('Y-m-d');
        $dataFim = $dataFim->format('Y-m-d');


        $funcionarioId = 5;
        $userInclusaoId = 12;


        $payload = [
            "funcionarioId" => $funcionarioId,
            "dataInicio" => $dataIni,
            "dataFim" => $dataFim,
            "userInclusaoId" => $userInclusaoId
        ];

        $client = static::createClient();
        $client->request(
            method: 'POST',
            uri: '/ferias',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($payload)
        );

        $response = $client->getResponse()->getContent();
        $this->assertResponseStatusCodeSame(400);
        $this->assertJson($response);
    }

    public function test_criar_ferias()
    {

        $faker = Factory::create('pt_BR');

        $dataIni = new DateTimeImmutable('+1 day');
        $dataFim = new DateTimeImmutable('+20 day');

        $dataIni = $dataIni->format('Y-m-d');
        $dataFim = $dataFim->format('Y-m-d');

        $funcionarioId = 7; // Funcionário que está ativo no banco de dados
        $userInclusaoId = 2;
        $payload = [
            "funcionarioId" => $funcionarioId,
            "dataInicio" => $dataIni,
            "dataFim" => $dataFim,
            "userInclusaoId" => $userInclusaoId
        ];
        $client = static::createClient();
        $client->request(
            method: 'POST',
            uri: '/ferias',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($payload)
        );
        $response = $client->getResponse()->getContent();
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(201);
        $this->assertJson($response);
        $responseData = json_decode($response, true);
        $this->assertArrayHasKey('data', $responseData);
        $this->assertArrayHasKey('id', $responseData['data']);
        $this->assertArrayHasKey('funcionarioId', $responseData['data']);
        $this->assertEquals($funcionarioId, $responseData['data']['funcionarioId']);
        $this->assertArrayHasKey('dataInicio', $responseData['data']);
        $this->assertEquals($dataIni, $responseData['data']['dataInicio']);
        $this->assertArrayHasKey('dataFim', $responseData['data']);                 
        $this->assertEquals($dataFim, $responseData['data']['dataFim']);
        $this->assertArrayHasKey('userInclusaoId', $responseData['data']);                      
    }
}
