<?php

namespace App\Entity\ValueObject;

use DateTimeImmutable;
use InvalidArgumentException;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class DataFerias
{
    #[ORM\Column(name: 'data_inicio')]
    private ?DateTimeImmutable $dataIni = null;

    #[ORM\Column(name: 'data_fim')]
    private ?DateTimeImmutable $dataFim = null;

    public function __construct(?DateTimeImmutable $dataIni = null, ?DateTimeImmutable $dataFim = null)
    {
        if ($dataIni && $dataFim && $dataFim < $dataIni) {
            throw new InvalidArgumentException('A data final não pode ser anterior à data inicial.');
        }

        $this->dataIni = $dataIni;
        $this->dataFim = $dataFim;
    }

    public function getDataIni(): ?DateTimeImmutable
    {
        return $this->dataIni;
    }

    public function getDataFim(): ?DateTimeImmutable
    {
        return $this->dataFim;
    }

    public function dataInicioFerias(): ?string
    {
        return $this->dataIni?->format('Y-m-d');
    }

    public function dataFimFerias(): ?string
    {
        return $this->dataFim?->format('Y-m-d');
    }

    public function getDiasDeFerias(): ?int
    {
        if (!$this->dataIni || !$this->dataFim) {
            return null;
        }

        return $this->dataFim->diff($this->dataIni)->days + 1;
    }
}

