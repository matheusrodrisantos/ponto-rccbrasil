<?php

namespace App\Sevice;

use App\Dto\DepartamentoDTO;
use App\Dto\FeriasDTO;
use App\Dto\FuncionarioDTO;
use App\Entity\Funcionario;
use App\Factory\FuncionarioFactory;
use App\Repository\FuncionarioRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FuncionarioService{

    private ?Funcionario $func;
    
    public function __construct(
        private FuncionarioRepository $funcionarioRepository,
        private FuncionarioFactory $funcionarioFactory
    ){}

    public function createEntity(FuncionarioDTO $funcDto):FuncionarioDTO{

        $this->func = $this->funcionarioFactory->createFromDto($funcDto);

        $this->funcionarioRepository->create($this->func);

        return $this->funcionarioFactory->createDtoFromEntity($this->func);

    }

    public function listarFeriasFuncionario(int $id){

        $this->func = $this->funcionarioRepository->find($id);
    }

    public function detalhe(int $id):?FuncionarioDTO {

        
        $this->func = $this->funcionarioRepository->buscarFuncionarioAtivoPorId($id);

        if (!$this->func) {
            throw new NotFoundHttpException("Funcionário não encontrado ou inativo.");
        }
        
        $feriasFuncionario=$this->func->getFerias();
        
        
        $departamentoDto = new DepartamentoDTO(
            nome: $this->func->getDepartamentoNome(),
            descricao: $this->func->getDepartamentoDescricao()
        );
        
        
        $registroPontoFuncionario=$this->func->getRegistroPontos();
        $saldoHorasFuncionario=$this->func->getSaldoHoras();
        $saldoHorasFuncionario=$this->func->getSaldoHoras();

        echo json_encode($feriasFuncionario);
        $ferias = [];

        foreach ($feriasFuncionario as $feria) {
            $ferias[] = [
                'id' => $feria->getId(),
                'dataInicio' => $feria->dataDeInicio(),
                'dataFim' => $feria->dataDeFim(),
                'funcionarioId'=>$feria->funcionario(),
                'userInclusaoId'=>$feria->responsavelPelaInclusao()
            ];
        }

        $funcDtoOut = new FuncionarioDTO(
            id:$this->func->getId(),
            cpf:$this->func->getCpf(),
            departamento:$departamentoDto,
            email: $this->func->getEmail(),
            nome:$this->func->getNome(),
            jornadaDiaria:$this->func->getJornadaDiaria(), 
            jornadaSemanal:$this->func->getJornadaSemanal(),
            regime:$this->func->getRegime(),
            verificarLocalizacao:$this->func->isVerificarLocalizacao(),
            ativo:$this->func->isAtivo(),
            ferias:$ferias
        );

        dump($funcDtoOut);

        return $funcDtoOut;
    }
}