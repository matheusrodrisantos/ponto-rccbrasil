<?php

namespace App\Tests\Controller;


use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Faker\Factory;

final class FeriasControllerTest extends WebTestCase
{

    public function test_create_ferias(){
        
        $dataIni = new DateTimeImmutable('+100 day')->format('Y-m-d');
        $dataFim = new DateTimeImmutable('+120 day')->format('Y-m-d');

        $funcionarioId=1;
        $userInclusaoId=2;


        $payload=[
            "funcionarioId"=>$funcionarioId, 
            "dataInicio"=>$dataIni, 
            "dataFim"=>$dataFim,
            "userInclusaoId"=>$userInclusaoId
        ];

        $client = static::createClient();
        $client->request(
            method:'POST',
            uri:'/ferias',
            server:['CONTENT_TYPE'=>'application/json'],
            content:json_encode($payload)
        );

        
        $response=$client->getResponse()->getContent();
        $responseData=json_decode($response);

        $this->assertResponseIsSuccessful(); 
        $this->assertResponseStatusCodeSame(201);
        $this->assertJson($response);
    }

    public function test_supervisor_diferente()  {

                
        $dataIni = new DateTimeImmutable('+61 day')->format('Y-m-d');
        $dataFim = new DateTimeImmutable('+90 day')->format('Y-m-d');

        $funcionarioId=5;
        $userInclusaoId=12;


        $payload=[
            "funcionarioId"=>$funcionarioId, 
            "dataInicio"=>$dataIni, 
            "dataFim"=>$dataFim,
            "userInclusaoId"=>$userInclusaoId
        ];

        $client = static::createClient();
        $client->request(
            method:'POST',
            uri:'/ferias',
            server:['CONTENT_TYPE'=>'application/json'],
            content:json_encode($payload)
        );

        
        $response=$client->getResponse()->getContent();
        var_dump($response);
        $this->assertResponseStatusCodeSame(400);
        $this->assertJson($response);
        
    }
}
