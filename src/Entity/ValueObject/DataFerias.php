<?php

namespace App\Entity\ValueObject;

use DateTimeImmutable;
use InvalidArgumentException;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class DataFerias
{
    private DateTimeImmutable $dataIni;
    private DateTimeImmutable $dataFim;

    public function __construct(DateTimeImmutable $dataIni, DateTimeImmutable $dataFim)
    {
        if ($dataFim < $dataIni) {
            throw new InvalidArgumentException('A data final não pode ser anterior à data inicial.');
        }

        $this->dataIni = $dataIni;
        $this->dataFim = $dataFim;
    }

    public function getDataIni(): DateTimeImmutable
    {
        return $this->dataIni;
    }

    public function getDataFim(): DateTimeImmutable
    {
        return $this->dataFim;
    }

    public function dataInicioFerias(): string
    {
        return $this->dataIni->format('Y-m-d');
    }

    public function dataFimFerias(): string
    {
        return $this->dataFim->format('Y-m-d');
    }

    public function getDiasDeFerias(): int
    {
        return $this->dataFim->diff($this->dataIni)->days + 1;
    }
}
