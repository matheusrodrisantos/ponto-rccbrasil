<?php

namespace App\Factory;

use App\Dto\DepartamentoDTO;
use App\Dto\FeriasDTO;
use App\Dto\FuncionarioDTO;
use App\Dto\Departamento\DepartamentoInputDTO;
use App\Dto\Departamento\DepartamentoOutputDTO;
use App\Entity\Funcionario;
use App\Entity\ValueObject\Cpf;
use App\Entity\ValueObject\Email;
use App\Entity\ValueObject\Jornada;
use App\Repository\DepartamentoRepository;

class FuncionarioFactory
{

    public function __construct(private DepartamentoRepository $departamentoRepository) {}

    public function createFromDto(FuncionarioDTO $func): Funcionario
    {
        $cpf = new Cpf($func->cpf);
        $email = new Email($func->email);
        $jornada = new Jornada($func->jornadaDiaria, $func->jornadaSemanal);

        $funcionario = new Funcionario($jornada, $cpf, $email);

        $funcionario
            ->setNome($func->nome)
            ->setRegime($func->regime)
            ->setFuncao($func->funcao)
            ->setVerificarLocalizacao($func->verificarLocalizacao)
            ->setAtivo($func->ativo);

        if ($func->departamentoId !== null) {
            $departamento = $this->departamentoRepository->find($func->departamentoId);
            $funcionario->setDepartamento($departamento);
        }

        return $funcionario;
    }

    public function createDtoFromEntity(Funcionario $funcionario): FuncionarioDTO
    {
        $dto = new FuncionarioDTO();
        $dto->id = $funcionario->getId();
        $dto->departamentoId = $funcionario->getDepartamentoId();
        $dto->cpf = (string) $funcionario->getCpf();
        $dto->email = (string) $funcionario->getEmail();
        $dto->jornadaDiaria = $funcionario->getJornadaDiaria();
        $dto->jornadaSemanal = $funcionario->getJornadaSemanal();
        $dto->nome = $funcionario->getNome();
        $dto->regime = $funcionario->getRegime();
        $dto->verificarLocalizacao = $funcionario->isVerificarLocalizacao();
        $dto->ativo = $funcionario->isAtivo();

        $listaFerias = $funcionario->getFerias();

        foreach ($listaFerias as $ferias) {
            $dto->ferias[] = new FeriasDTO(
                dataInicio: $ferias->dataDeInicio(),
                dataFim: $ferias->dataDeFim(),
                funcionarioId: $ferias->funcionario(),
                userInclusaoId: $ferias->responsavelPelaInclusao(),
                id: $ferias->getId()
            );
        }

        $dto->departamento = new DepartamentoOutputDTO(
            nome: $funcionario->getDepartamentoNome(),
            descricao: $funcionario->getDepartamentoDescricao()
        );


        return $dto;
    }
}
