<?php

namespace App\Dto;

use App\Entity\Enum\FeriadoNivel;


final class FeriadoOutputDTO implements DtoInteface
{

    public ?string $nome = null;

    public ?string $data = null;

    public ?FeriadoNivel $nivel = null;

    public ?bool $recorrente = null;

    public function __construct(
        ?string $nome,
        ?string $data,
        ?FeriadoNivel $nivel,
        ?bool $recorrente
    ) {
        $this->nome = $nome;
        $this->data = $data;
        $this->nivel = $nivel;
        $this->recorrente = $recorrente;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            nome: $data['nome'] ?? null,
            data: $data['data'] ?? null,
            nivel: isset($data['nivel']) ? FeriadoNivel::tryFrom($data['nivel']) : null,
            recorrente: $data['recorrente'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'nome' => $this->nome,
            'data' => $this->data,
            'nivel' => $this->nivel?->value,
            'recorrente' => $this->recorrente,
        ];
    }
}
