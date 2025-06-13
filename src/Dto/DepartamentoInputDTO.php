<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class DepartamentoInputDTO
{
    #[Assert\NotBlank(message: "O nome do departamento não pode estar em branco.")]
    #[Assert\Length(
        min: 3,
        max: 255,
        minMessage: "O nome do departamento deve ter pelo menos {{ limit }} caracteres.",
        maxMessage: "O nome do departamento não pode ter mais de {{ limit }} caracteres."
    )]
    public ?string $nome = null;

    #[Assert\Length(
        max: 1000,
        maxMessage: "A descrição não pode ter mais de {{ limit }} caracteres."
    )]
    public ?string $descricao = null;

    #[Assert\Positive(message: "O ID do supervisor deve ser um número positivo.")]
    public ?int $supervisorId = null;

    public ?bool $ativo = true; // Default to true, can be overridden

    public function __construct(
        ?string $nome = null,
        ?string $descricao = null,
        ?int $supervisorId = null,
        ?bool $ativo = true
    ) {
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->supervisorId = $supervisorId;
        $this->ativo = $ativo;
    }
}
