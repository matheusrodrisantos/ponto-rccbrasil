<?php

namespace App\Sevice;
use App\Dto\FeriasDTO;
use App\Entity\Ferias;
use App\Factory\FeriasFactory;
use App\Repository\FeriasRepository;

class FeriasService
{
    private Ferias $ferias;

    public function __construct(
        private FeriasFactory $feriasFactory,
        private FeriasRepository $feriasRepository
    ){}

    public function createEntity(FeriasDTO $feriasInputDto) :FeriasDTO {

        $this->ferias = $this->feriasFactory->createEntityFromDto($feriasInputDto);

        $this->feriasRepository->create($this->ferias);

        return $this->feriasFactory->createDtoFromEntity($this->ferias);

    }


}