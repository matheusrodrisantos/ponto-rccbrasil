<?php

namespace App\Service;

use App\Dto\FeriadoInputDTO;  // Changed
use App\Dto\FeriadoOutputDTO; // Added
use App\Entity\Feriado;
use App\Exception\FeriadoNotFoundException;
use App\Exception\RegraDeNegocioFeriadoException;
use App\Factory\FeriadoFactory;
use App\Repository\FeriadoRepository;
// Removed unused DateTime, Date constraint, EntityManagerInterface
use DateTimeImmutable;

final class FeriadoService
{
    public function __construct(
        private readonly FeriadoRepository $feriadoRepository,
        private readonly FeriadoFactory $feriadoFactory
    ) {}

    // Updated parameter and return type
    public function criarFeriado(FeriadoInputDTO $feriadoInputDto): FeriadoOutputDTO
    {
        // InputDTO data property is string, needs conversion for comparison
        $dataFeriado = new DateTimeImmutable($feriadoInputDto->data);

        $existingFeriado = $this->feriadoRepository->findByDate($dataFeriado);
        if ($existingFeriado) {
            throw new RegraDeNegocioFeriadoException('Já existe um feriado cadastrado para esta data.');
        }

        $feriado = $this->feriadoFactory->createEntityFromInputDTO($feriadoInputDto);
        $this->feriadoRepository->create($feriado);

        return $this->feriadoFactory->createOutputDTOFromEntity($feriado); // Return OutputDTO
    }

    // Updated return type
    public function buscarFeriadoPorData(DateTimeImmutable $data): ?FeriadoOutputDTO
    {
        $feriado = $this->feriadoRepository->findByDate($data);
        if ($feriado === null) {
            throw new FeriadoNotFoundException('Feriado não encontrado para a data informada.');
        }

        return $this->feriadoFactory->createOutputDTOFromEntity($feriado); // Return OutputDTO
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
        return $dtos; // Return array of OutputDTOs
    }

    // This method still expects an entity. If it's called externally,
    // the caller would need to fetch the entity first.
    // For now, its signature remains unchanged as it's not directly part of create/read DTO flow.
    public function excluirFeriado(Feriado $feriado): void
    {
        $this->feriadoRepository->delete($feriado);
    }
}
