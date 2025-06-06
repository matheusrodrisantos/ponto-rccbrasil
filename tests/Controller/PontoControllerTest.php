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
}
