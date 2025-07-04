<?php

namespace App\Tests\Controller;

use App\Entity\Departamento;
use App\Entity\Enum\Funcao;
use App\Entity\Funcionario;
use App\Entity\ValueObject\Cpf;
use App\Entity\ValueObject\Email;
use App\Entity\ValueObject\Jornada;
use App\Tests\Helper\FakeDepartamentoTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class DepartamentoControllerTest extends WebTestCase
{
    use FakeDepartamentoTrait;

    private $client;
    private $entityManager;
    private $departamentoRepository;


    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->entityManager = $this->client->getContainer()->get('doctrine.orm.entity_manager');
        $this->departamentoRepository = $this->entityManager->getRepository(Departamento::class);
    }

    public function test_falhar_criar_departamento_mesmo_supervisor(): void
    {


        $jornada = new Jornada('08:00:00','44:00:00');
        $cpf = new Cpf('43523797861');
        $email = new Email('suporteti@rccbrasil.org.br');

        $funcionario = new Funcionario($jornada, $cpf, $email);   
        $funcionario->setNome('Joao Carlos martins');
        $funcionario->setFuncao(Funcao::SUPERVISOR);
        $funcionario->setAtivo(true);


        $departamento = new Departamento();
        $departamento->setNome('DEPARTAMENTO DOS JOÃOS ANONIMOS ');
        $departamento->setDescricao('Este deparamento são de todos as pessoas que se 
            chamam João mas não querem ser reconhecidas');
        $departamento->setSupervisor($funcionario);



        $payload = $this->gerarPayloadDepartamento();

        $client = static::createClient();
        $client->request(
            method: 'POST',
            uri: 'api/departamento',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($payload)
        );

        $this->assertResponseStatusCodeSame(400);
        $this->assertJson($client->getResponse()->getContent());
    }
}
