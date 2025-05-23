<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Tests\Helper\FakeFuncionarioTrait;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class FuncionarioControllerTest extends WebTestCase
{
    use FakeFuncionarioTrait;

    private $client;

    public function setUp() :void{
        $this->client = static::createClient();
    }
    

    public function test_create_funcionario(){

        $payload=$this->gerarPayloadFuncionario();

        $this->client->request(
            method:'POST',
            uri: 'api/funcionario',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($payload)
        );

        $this->assertResponseIsSuccessful(); 
        $this->assertResponseStatusCodeSame(201);
        $this->assertJson($this->client->getResponse()->getContent());

        $responseData = json_decode($this->client->getResponse()->getContent());

        $this->assertNotEmpty($responseData->data->id);
        $this->assertNotEmpty($responseData->data->cpf);
        $this->assertNotEmpty($responseData->data->email);
        $this->assertNotEmpty($responseData->data->nome);
        $this->assertNotEmpty($responseData->data->jornadaDiaria);
        $this->assertNotEmpty($responseData->data->jornadaSemanal);
        $this->assertNotEmpty($responseData->data->regime);
        $this->assertNotEmpty($responseData->data->departamentoId);

    }

    public function test_list_detalhes_funcionario(){
        
        $id = 1;// sei que esse login está ativado no banco

        $this->client->request(
            method:'GET',
            uri: "api/funcionario/{$id}/perfil-completo"
        );

        $this->assertResponseIsSuccessful(); 
    }

    public function test_erro_listar_detalhes_funcionario(){
        
        $id = 2;// sei que esse login está desativado no banco

        $this->client->request(
            method:'GET',
            uri: "api/funcionario/{$id}/perfil-completo"
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());

    }
}
