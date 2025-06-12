<?php

namespace App\Service;

use App\Dto\FeriadoDTO;
use App\Entity\Feriado;
use App\Exception\RegraDeNegocioFeriadoException;
use App\Factory\FeriadoFactory;
use App\Repository\FeriadoRepository;
use Doctrine\ORM\EntityManagerInterface;
use DateTimeImmutable;

final class FeriadoService
{
    public function __construct(
        private readonly FeriadoRepository $feriadoRepository,
        private readonly FeriadoFactory $feriadoFactory,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function criarFeriado(FeriadoDTO $feriadoDTO): Feriado
    {
        $dataFeriado = new DateTimeImmutable($feriadoDTO->data);

        // Check if a holiday with the same date already exists
        $existingFeriado = $this->feriadoRepository->findByDate($dataFeriado);

        if ($existingFeriado) {
            throw new RegraDeNegocioFeriadoException('Já existe um feriado cadastrado para esta data.');
        }

        $feriado = $this->feriadoFactory->createFromDTO($feriadoDTO);

        $this->entityManager->persist($feriado);
        $this->entityManager->flush();

        return $feriado;
    }
}
