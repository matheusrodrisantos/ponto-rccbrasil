<?php

namespace App\Entity\ValueObject;

use DateTimeImmutable;
use DateTimeInterface;
use InvalidArgumentException;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\ValueObject\DiaSemana;

#[ORM\Embeddable]
class DataFerias
{
    #[ORM\Column(name: 'data_inicio')]
    private ?DateTimeImmutable $dataIni = null;

    #[ORM\Column(name: 'data_fim')]
    private ?DateTimeImmutable $dataFim = null;

    public function __construct(?DateTimeImmutable $dataIni = null, ?DateTimeImmutable $dataFim = null)
    {
        $this->validar($dataIni, $dataFim);

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

    public function contagemDiasCorridos(): ?int
    {
        if (!$this->dataIni || !$this->dataFim) {
            return null;
        }

        return $this->dataFim->diff($this->dataIni)->days + 1;
    }

    public function validar(?DateTimeInterface $dataInicio, ?DateTimeInterface $dataFim): void
    {
        $this->verificarDatasInicioFimMenor($dataInicio, $dataFim);
        $this->verificarDiasCorridos($dataInicio, $dataFim);
        $this->ehDomingo($dataInicio);
    }

    public function verificarDatasInicioFimMenor(
        DateTimeInterface $dataInicio,
        DateTimeInterface $dataFim
    ): void {
        if ($dataInicio && $dataFim && $dataFim < $dataInicio) {
            throw new InvalidArgumentException('A data final não pode ser anterior à data inicial.');
        }
    }

    public function verificarDiasCorridos(
        DateTimeInterface $dataInicio,
        DateTimeInterface $dataFim
    ): void {

        $diasCorridos = $dataFim->diff($dataInicio)->days + 1;
        if ($diasCorridos < 5) {
            throw new InvalidArgumentException('Férias não pode ser inferior a 5 dias');
        }
    }

    public function verificaFeriasAtiva(): bool
    {
        if ($this->dataIni && $this->dataFim) {
            $hoje = new DateTimeImmutable();
            if ($hoje >= $this->dataIni && $hoje <= $this->dataFim) {
                return true;
            }
        }
        return false;
    }
    public function ehDomingo(DateTimeInterface $data): void
    {
        $diaSemana = new DiaSemana($data);
        if ($diaSemana->ehDomingo()) {
            throw new InvalidArgumentException('Férias não pode iniciar em um domingo');
        }
    }
}
