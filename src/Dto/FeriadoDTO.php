<?php

namespace App\Dto;

use App\Entity\Enum\FeriadoNivel;
use Symfony\Component\Validator\Constraints as Assert;

final class FeriadoDTO implements DtoInteface
{
    #[Assert\NotBlank(message: 'O nome do feriado não pode estar em branco.')]
    #[Assert\Length(min: 3, max: 255, minMessage: 'O nome deve ter no mínimo 3 caracteres.', maxMessage: 'O nome deve ter no máximo 255 caracteres.')]
    public ?string $nome = null;

    #[Assert\NotBlank(message: 'A data do feriado não pode estar em branco.')]
    #[Assert\Date(message: 'A data do feriado deve ser uma data válida.')]
    public ?string $data = null;

    #[Assert\NotBlank(message: 'O nível do feriado não pode estar em branco.')]
    public ?FeriadoNivel $nivel = null;

    #[Assert\NotNull(message: 'O campo recorrente não pode ser nulo.')]
    #[Assert\Type(type: 'bool', message: 'O campo recorrente deve ser um booleano.')]
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
