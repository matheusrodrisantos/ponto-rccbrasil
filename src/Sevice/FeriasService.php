<?php

namespace App\Sevice;
use App\Dto\FeriasDTO;
use App\Entity\Ferias;
use App\Entity\ValueObject\DataFerias;
use App\Factory\FeriasFactory;
use App\Repository\FeriasRepository;
use App\Repository\FuncionarioRepository;
use App\Service\RegrasFerias\SupervisorFeriasRegras;
use App\Sevice\RegrasFerias\CadeiaRegras;
use App\Sevice\RegrasFerias\FuncionarioFeriasRegras;
use App\Sevice\RegrasFerias\PeriodoFeriasRegras;
use DateTimeImmutable;


class FeriasService
{
    public function __construct(
        private FeriasFactory $feriasFactory,
        private FeriasRepository $feriasRepository,
        private FuncionarioRepository $funcionarioRepository
    ){}

    public function createEntity(FeriasDTO $feriasInputDto)  {

        $dataInicio= new DateTimeImmutable($feriasInputDto->dataInicio);
        $dataFim= new DateTimeImmutable($feriasInputDto->dataFim);
        
        $dataFerias = new DataFerias($dataInicio, $dataFim);

        $cadeiaRegras = new CadeiaRegras([
            new FuncionarioFeriasRegras($this->funcionarioRepository), 
            new PeriodoFeriasRegras($this->feriasRepository), 
            new SupervisorFeriasRegras($this->funcionarioRepository)
        ]);

        $cadeiaRegras->validar($feriasInputDto);

        $ferias = new Ferias($dataFerias);
    
        $funcionario=$this->funcionarioRepository->find($feriasInputDto->funcionarioId);
        $responsavel=$this->funcionarioRepository->find($feriasInputDto->userInclusaoId);

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