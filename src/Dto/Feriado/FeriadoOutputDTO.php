<?php

namespace App\Dto\Feriado;

use App\Entity\Enum\FeriadoNivel;


final class FeriadoOutputDTO implements FeriadoInterfaceDTO
{

    public ?string $nome = null;

    public ?string $data = null;

    public ?FeriadoNivel $nivel = null;


    public function __construct(
        ?string $nome,
        ?string $data,
        ?FeriadoNivel $nivel,

    ) {
        $this->nome = $nome;
        $this->data = $data;
        $this->nivel = $nivel;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            nome: $data['nome'] ?? null,
            data: $data['data'] ?? null,
            nivel: isset($data['nivel']) ? FeriadoNivel::tryFrom($data['nivel']) : null,
        );
    }

    public function toArray(): array
    {
        return [
            'nome' => $this->nome,
            'data' => $this->data,
            'nivel' => $this->nivel?->value
        ];
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function getData(): ?string
    {
        return $this->data;
    }

    public function getNivel(): ?FeriadoNivel
    {
        return $this->nivel;
    }
}
