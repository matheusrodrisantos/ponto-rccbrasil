<?php

namespace App\Service;

use App\Dto\Feriado\FeriadoInputDTO;
use App\Dto\Feriado\FeriadoOutputDTO;
use App\Entity\Feriado;
use App\Entity\ValueObject\DataFeriado;
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
        $dataFeriado = new DataFeriado($data);

        $feriado = $this->feriadoRepository->findByDateActive($dataFeriado);

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

    public function desabilitarFeriado($data):bool
    {
        $dataFeriado = new DataFeriado($data);

        $feriado = $this->feriadoRepository->findByDate($dataFeriado);

        if ($feriado === null) {
            throw new FeriadoNotFoundException('Feriado na data informada não encontrado');
        }

        $feriado->changeStatus();

        $this->feriadoRepository->update($feriado);

        return $feriado->isStatus();
    }

    public function excluirFeriado(Feriado $feriado): void
    {
        $this->feriadoRepository->delete($feriado);
    }
}
