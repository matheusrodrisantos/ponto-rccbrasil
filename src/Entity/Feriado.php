<?php

namespace App\Entity;

use App\Entity\Enum\FeriadoNivel;
use App\Repository\FeriadoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FeriadoRepository::class)]
class Feriado
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $data = null;

    #[ORM\Column(enumType: FeriadoNivel::class)]
    private ?FeriadoNivel $nivel = null;

    #[ORM\Column]
    private ?bool $recorrente = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $inicio = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $fim = null;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getData(): ?\DateTimeImmutable
    {
        return $this->data;
    }

    public function setData(\DateTimeImmutable $data): static
    {
        $this->data = $data;

        return $this;
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
        $this->inicio = $inicio;

        return $this;
    }

    public function getFim(): ?\DateTimeImmutable
    {
        return $this->fim;
    }

    public function setFim(\DateTimeImmutable $fim): static
    {
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
