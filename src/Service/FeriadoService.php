<?php

namespace App\Service;

use App\Dto\FeriadoDTO;
use App\Entity\Feriado;
use App\Exception\RegraDeNegocioFeriadoException;
use App\Factory\FeriadoFactory;
use App\Repository\FeriadoRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use DateTimeImmutable;
use Symfony\Component\Validator\Constraints\Date;

final class FeriadoService
{
    public function __construct(
        private readonly FeriadoRepository $feriadoRepository,
        private readonly FeriadoFactory $feriadoFactory
    ) {}

    public function criarFeriado(FeriadoDTO $feriadoDTO): Feriado
    {
        $dataFeriado = new DateTimeImmutable($feriadoDTO->data);

        $existingFeriado = $this->feriadoRepository->findByDate($dataFeriado);
        if ($existingFeriado) {
            throw new RegraDeNegocioFeriadoException('Já existe um feriado cadastrado para esta data.');
        }

        $feriado = $this->feriadoFactory->createFromDTO($feriadoDTO);

        $this->feriadoRepository->create($feriado);

        return $feriado;
    }
}
