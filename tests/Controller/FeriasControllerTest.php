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
}
