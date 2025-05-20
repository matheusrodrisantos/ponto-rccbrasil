<?php

namespace App\Tests\Controller;

use App\Tests\Helper\FakeDepartamentoTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class DepartamentoControllerTest extends WebTestCase
{
    use FakeDepartamentoTrait;

    public function test_create_departamento(): void
    {
        $payload=$this->gerarPayloadDepartamento();

        $client = static::createClient();
        $client->request(
            method:'POST', 
            uri:'/departamento',
            server:['CONTENT_TYPE'=>'application/json'],
            content:json_encode($payload)
        );

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(201);
        $this->assertJson($client->getResponse()->getContent());
    }
}
