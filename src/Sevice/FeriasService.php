<?php

namespace App\Sevice;
use App\Dto\FeriasDTO;
use App\Entity\Ferias;
use App\Entity\ValueObject\DataFerias;
use App\Factory\FeriasFactory;
use App\Repository\FeriasRepository;
use App\Repository\FuncionarioRepository;
use DateTimeImmutable;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FeriasService
{
    private Ferias $ferias;

    public function __construct(
        private FeriasFactory $feriasFactory,
        private FeriasRepository $feriasRepository,
        private FuncionarioRepository $funcionarioRepository
    ){}

    public function createEntity(FeriasDTO $feriasInputDto)  {

        $dataInicio= new DateTimeImmutable($feriasInputDto->dataInicio);
        $dataFim= new DateTimeImmutable($feriasInputDto->dataFim);
        
        $dataFerias = new DataFerias($dataInicio, $dataFim);

        $ferias = new Ferias($dataFerias);

        if($feriasInputDto->funcionarioId===null){            
            throw new InvalidArgumentException('Precisa de um funcionario');
        }

        
        $funcionario=$this->funcionarioRepository->find($feriasInputDto->funcionarioId);
        
        if (!$funcionario) {
            throw new NotFoundHttpException("Funcionario com ID {$feriasInputDto->funcionarioId} não encontrado.");
        }

        if($feriasInputDto->userInclusaoId===null){
            throw new InvalidArgumentException('Precisa de um supervisor que adicione');
        }

        $responsavel=$this->funcionarioRepository->find($feriasInputDto->userInclusaoId);

        if (!$responsavel) {
            throw new NotFoundHttpException("Supervisor com ID {$feriasInputDto->userInclusaoId} não encontrado.");
        }

        $ferias->definirFuncionario($funcionario);
        $ferias->definirResponsavelPelaInclusao($responsavel);

        $this->feriasRepository->create($ferias);


        return new FeriasDTO(
            $ferias->funcionario(),
            $ferias->responsavelPelaInclusao(), 
            $ferias->dataDeInicio(),
            $ferias->dataDeFim(), 
            $ferias->getId()
        );

    }


}