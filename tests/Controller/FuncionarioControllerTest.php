<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Tests\Helper\FakeFuncionarioTrait;

final class FuncionarioControllerTest extends WebTestCase
{
    use FakeFuncionarioTrait;

    public function test_create_funcionario(){

        $client = static::createClient();
        
        $payload=$this->gerarPayloadFuncionario();

        $client->request(
            method:'POST',
            uri: '/funcionario',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($payload)
        );

        $this->assertResponseIsSuccessful(); 
        $this->assertResponseStatusCodeSame(201);
        $this->assertJson($client->getResponse()->getContent());

        $responseData = json_decode($client->getResponse()->getContent(), true);
        

    }
}
