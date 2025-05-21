<?php

namespace App\Tests\Controller;


use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Faker\Factory;

final class FeriasControllerTest extends WebTestCase
{

    public function test_create_ferias(){
        
        $faker=Factory::create('pt_BR');

        $dataIni = new DateTimeImmutable('+1 day')->format('Y-m-d');
        $dataFim = new DateTimeImmutable('+30 day')->format('Y-m-d');

        $funcionarioId=$faker->numberBetween(1,2);
        $userInclusaoId=$faker->randomDigitNotNull(3,4);


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

        print_r($responseData);
        $this->assertResponseIsSuccessful(); 
        $this->assertResponseStatusCodeSame(201);
        $this->assertJson($response);
        $this->assertNotEmpty($responseData->funcionarioId);
        $this->assertNotEmpty($responseData->userInclusaoId);

    }
}
