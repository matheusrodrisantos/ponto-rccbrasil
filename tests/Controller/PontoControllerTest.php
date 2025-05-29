<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class PontoControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/ponto');

        self::assertResponseIsSuccessful();
    }

    public function test_create_ponto()
    {

        $payload = [
            "funcionarioId" => 1,
            "hora" => "10:00:00",
            "data" => "2025-05-29"
        ];

        $client = static::createClient();

        $client->request(
            method: 'POST',
            uri: 'api/ponto',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($payload)
        );

        self::assertResponseIsSuccessful();
    }
}
