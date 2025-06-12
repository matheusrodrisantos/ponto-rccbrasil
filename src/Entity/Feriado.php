<?php

namespace App\Entity;

use App\Entity\Enum\FeriadoNivel;
use App\Exception\RegraDeNegocioFeriadoException;
use App\Repository\FeriadoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FeriadoRepository::class)]
class Feriado
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['feriado:read'])]
    private ?int $id = null;

    #[ORM\Column(enumType: FeriadoNivel::class)]
    #[Groups(['feriado:read'])]
    private ?FeriadoNivel $nivel = null;

    #[ORM\Column]
    #[Groups(['feriado:read'])]
    private ?bool $recorrente = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Groups(['feriado:read'])]
    private ?\DateTimeImmutable $inicio = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Groups(['feriado:read'])]
    private ?\DateTimeImmutable $fim = null;

    #[ORM\Column(length: 255)]
    #[Groups(['feriado:read'])]
    private ?string $nome = null;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getNivel(): ?FeriadoNivel
    {
        return $this->nivel;
    }

    public function setNivel(FeriadoNivel $nivel): static
    {
        $this->nivel = $nivel;

        return $this;
    }

    public function isRecorrente(): ?bool
    {
        return $this->recorrente;
    }

    public function setRecorrente(bool $recorrente): static
    {
        $this->recorrente = $recorrente;

        return $this;
    }

    public function getInicio(): ?\DateTimeImmutable
    {
        return $this->inicio;
    }

    public function setInicio(\DateTimeImmutable $inicio): static
    {
        if ($this->inicio === null && $inicio < new \DateTimeImmutable()) {
            throw new RegraDeNegocioFeriadoException("A data de fim não pode ser anterior à data atual.");
        }
        if ($this->fim !== null && $inicio > $this->fim) {
            throw new RegraDeNegocioFeriadoException("A data de início não pode ser posterior à data de fim.");
        }
        if ($this->fim !== null && $inicio->diff($this->fim)->days > 365) {
            throw new RegraDeNegocioFeriadoException("A data de início não pode ser mais de 365 dias antes da data de fim.");
        }
        if ($this->inicio !== null && $inicio->diff($this->inicio)->days > 365) {
            throw new RegraDeNegocioFeriadoException("A data de início não pode ser mais de 365 dias após a data de início atual.");
        }
        if ($this->fim === null && $inicio->diff(new \DateTimeImmutable())->days > 365) {
            throw new RegraDeNegocioFeriadoException("A data de início não pode ser mais de 365 dias após a data atual.");
        }
        $this->inicio = $inicio;

        return $this;
    }

    public function getFim(): ?\DateTimeImmutable
    {

        return $this->fim;
    }

    public function setFim(\DateTimeImmutable $fim): static
    {

        if ($this->inicio !== null && $fim < $this->inicio) {
            throw new RegraDeNegocioFeriadoException("A data de fim não pode ser anterior à data de início.");
        }
        if ($this->inicio !== null && $fim->diff($this->inicio)->days > 365) {
            throw new RegraDeNegocioFeriadoException("A data de fim não pode ser mais de 365 dias após a data de início.");
        }

        if ($this->inicio === null && $fim->diff(new \DateTimeImmutable())->days > 365) {
            throw new RegraDeNegocioFeriadoException("A data de fim não pode ser mais de 365 dias após a data atual.");
        }
        $this->fim = $fim;

        return $this;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): static
    {
        $this->nome = $nome;

        return $this;
    }
}
