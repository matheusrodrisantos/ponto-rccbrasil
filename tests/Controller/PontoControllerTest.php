<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class PontoControllerTest extends WebTestCase
{
    public function tesDtIndex(): void
    {
        $client = static::createClient();
        $client->request(method:'GET', uri:'/ponto',
        server: ['CONTENT_TYPE' => 'application/json', 'accept' => 'application/json']
    );

        self::assertResponseIsSuccessful();
    }

    public function test_create_ponto()
    {

        $payload = [
            "funcionarioId" => 1,
        ];

        $client = static::createClient();

        $client->request(
            method: 'POST',
            uri: 'api/ponto',
            server: ['CONTENT_TYPE' => 'application/json', 'accept' => 'application/json'],
            content: json_encode($payload)
        );

        dump($client->getResponse()->getContent());

        self::assertResponseIsSuccessful();
    }

    public function test_create_ponto_funcionario_bloqueado()
    {
        $payload = [
            "funcionarioId" => 4, // Funcionário bloqueado
        ];

        $client = static::createClient();

        $client->request(
            method: 'POST',
            uri: 'api/ponto',
            server: ['CONTENT_TYPE' => 'application/json', 'accept' => 'application/json'],
            content: json_encode($payload)
        );

        self::assertResponseStatusCodeSame(400);
        self::assertJson($client->getResponse()->getContent());
       
    }
    public function test_create_ponto_funcionario_inexistente()
    {
        $payload = [
            "funcionarioId" => 9999, // ID de funcionário inexistente
        ];

        $client = static::createClient();

        $client->request(
            method: 'POST',
            uri: 'api/ponto',
            server: ['CONTENT_TYPE' => 'application/json', 'accept' => 'application/json'],
            content: json_encode($payload)
        );

        self::assertResponseStatusCodeSame(404);
        self::assertJson($client->getResponse()->getContent());
    }
    public function test_create_ponto_json_malformatado()
    {
        $payload = "{ 'funcionarioId': 1 }"; // JSON malformatado

        $client = static::createClient();

        $client->request(
            method: 'POST',
            uri: 'api/ponto',
            server: ['CONTENT_TYPE' => 'application/json', 'accept' => 'application/json'],
            content: $payload
        );

        self::assertResponseStatusCodeSame(400);
        self::assertJson($client->getResponse()->getContent());
        self::assertStringContainsString('JSON malformatado', $client->getResponse()->getContent());
    }
     public function test_create_ponto_sem_funcionario_id()
    {
        $payload = []; // Sem o campo funcionarioId

        $client = static::createClient();

        $client->request(
            method: 'POST',
            uri: 'api/ponto',
            server: ['CONTENT_TYPE' => 'application/json', 'accept' => 'application/json'],
            content: json_encode($payload)
        );

        self::assertResponseStatusCodeSame(400);
        self::assertJson($client->getResponse()->getContent());
        self::assertStringContainsString('O campo funcionarioId é obrigatório', $client->getResponse()->getContent());
    }

    public function test_create_ponto_funcionario_de_ferias()
    {
        $payload = [
            "funcionarioId" => 3, // Funcionário de férias
        ];

        $client = static::createClient();

        $client->request(
            method: 'POST',
            uri: 'api/ponto',
            server: ['CONTENT_TYPE' => 'application/json', 'accept' => 'application/json'],
            content: json_encode($payload)
        );

        self::assertResponseStatusCodeSame(400);
        self::assertJson($client->getResponse()->getContent());
        self::assertStringContainsString('Funcionário está de férias e não pode registrar ponto', $client->getResponse()->getContent());
    }
   
}
