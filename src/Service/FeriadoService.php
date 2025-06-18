<?php

namespace App\Service;

use App\Dto\Feriado\FeriadoInputDTO;  
use App\Dto\Feriado\FeriadoOutputDTO; 
use App\Entity\Feriado;
use App\Exception\FeriadoNotFoundException;
use App\Exception\RegraDeNegocioFeriadoException;
use App\Factory\FeriadoFactory;
use App\Repository\FeriadoRepository;

use DateTimeImmutable;

final class FeriadoService
{
    public function __construct(
        private readonly FeriadoRepository $feriadoRepository,
        private readonly FeriadoFactory $feriadoFactory
    ) {}

    
    public function criarFeriado(FeriadoInputDTO $feriadoInputDto): FeriadoOutputDTO
    {
        
        $feriado = $this->feriadoFactory->createEntityFromInputDTO($feriadoInputDto);
        $this->feriadoRepository->create($feriado);

        return $this->feriadoFactory->createOutputDTOFromEntity($feriado); 
    }

    
    public function buscarFeriadoPorData(DateTimeImmutable $data): ?FeriadoOutputDTO
    {
        $feriado = $this->feriadoRepository->findByDate($data);
        if ($feriado === null) {
            throw new FeriadoNotFoundException('Feriado não encontrado para a data informada.');
        }

        return $this->feriadoFactory->createOutputDTOFromEntity($feriado); 
    }

    /**
     * @return FeriadoOutputDTO[]
     */
    public function buscarTodosFeriados(): array
    {
        $feriados = $this->feriadoRepository->findAll();
        $dtos = [];
        foreach ($feriados as $feriado) {
            $dtos[] = $this->feriadoFactory->createOutputDTOFromEntity($feriado);
        }
        return $dtos; 
    }

    
    
    
    public function excluirFeriado(Feriado $feriado): void
    {
        $this->feriadoRepository->delete($feriado);
    }
}
