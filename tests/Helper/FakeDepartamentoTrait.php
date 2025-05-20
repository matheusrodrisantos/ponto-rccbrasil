<?php

namespace App\Tests\Helper;

use App\Dto\DepartamentoDTO;
use App\Entity\Departamento;
use Faker\Factory;


trait FakeDepartamentoTrait
{
    use FakeFuncionarioTrait;

    
    protected function criarDepartamento(): Departamento
    {
        $faker = Factory::create('pt_BR');

        $departamento = new Departamento();
        $departamento->setNome($faker->randomElement([
            'Recursos Humanos', 'Financeiro', 'Tecnologia da Informação',
            'Jurídico', 'Marketing', 'Comercial', 'Logística'
        ]));
        $departamento->setDescricao($faker->sentence());
        $departamento->setAtivo($faker->boolean());

        $supervisor= $this->criarFuncionario();  

        $departamento->setSupervisor($supervisor);

        return $departamento;
    }

    protected function criarDepartamentoDto():DepartamentoDTO{
     
        $faker = Factory::create('pt_BR');
        $supervisor = $this->criarFuncionario();

        return new DepartamentoDTO(
            id: null, 
            nome: $faker->randomElement([
                'Recursos Humanos', 'Financeiro', 'Tecnologia da Informação',
                'Jurídico', 'Marketing', 'Comercial', 'Logística'
            ]),
            descricao: $faker->sentence(),
            supervisor: $supervisor,
            ativo: $faker->boolean()
        );
     
    }

    protected function gerarPayloadDepartamento(): array
    {
        $faker = Factory::create('pt_BR');

        $supervisor = $this->criarFuncionario();

        return [
            'id' => null,
            'nome' => $faker->randomElement([
                'Recursos Humanos', 'Financeiro', 'Tecnologia da Informação',
                'Jurídico', 'Marketing', 'Comercial', 'Logística'
            ]),
            'descricao' => $faker->sentence(),
            'supervisor' => [
                'id' => $supervisor->getId(),
                'nome' => $supervisor->getNome(),
                'email' => $supervisor->getEmail(),
                'cpf' => $supervisor->getCpf(),
            ],
            'ativo' => $faker->boolean()
        ];
    }
}
