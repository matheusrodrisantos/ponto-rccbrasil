<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class FuncionarioControllerTest extends WebTestCase
{

    public function test_create_funcionario(){

        $client = static::createClient();


        $payload=[
          "id" => 1,
            "cpf" => "123.456.789-00",
            "roles" => ["ROLE_USER", "ROLE_ADMIN"],
            "password" => "SenhaForte123!",
            "email" => "usuario@example.com",
            "nome" => "João da Silva",
            "jornadaDiaria" => "08:00:00",
            "jornadaSemanal" => "40:00:00",
            "regime" => "PRESENCIAL",
            "verificarLocalizacao" => true,
            "ativo" => true  
        ];

        $client->request(
            method:'POST',
            uri: '/funcionario',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($payload)
        );

        $this->assertResponseIsSuccessful(); 
        $this->assertResponseStatusCodeSame(201); // se espera CREATED
        $this->assertJson($client->getResponse()->getContent());

        $responseData = json_decode($client->getResponse()->getContent(), true);
        

    }
}
