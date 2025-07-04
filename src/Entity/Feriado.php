<?php

namespace App\Entity;

use App\Entity\Enum\FeriadoNivel;
use App\Entity\trait\TimestampableTrait;
use App\Entity\ValueObject\DataFeriado;
use App\Repository\FeriadoRepository;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: FeriadoRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Feriado
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: FeriadoNivel::class)]
    private ?FeriadoNivel $nivel = null;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\Embedded(DataFeriado::class, 'data_')]
    private ?DataFeriado $data = null;

    #[ORM\Column(options: ['default' => true])]
    private ?bool $status = true;

    public function __construct(DataFeriado $data)
    {
        $this->data = $data;
        $this->status = true;
    }

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

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): static
    {
        $this->nome = $nome;

        return $this;
    }

    public function getData(): ?DataFeriado
    {
        return $this->data;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }
}
