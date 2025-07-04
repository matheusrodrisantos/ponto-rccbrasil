<?php

namespace App\Dto\Feriado;

use App\Entity\Enum\FeriadoNivel;
use Symfony\Component\Validator\Constraints as Assert;

class FeriadoInputDTO
{
    #[Assert\NotBlank(message: "O nome do feriado não pode estar em branco.")]
    #[Assert\Length(
        min: 3,
        max: 255,
        minMessage: "O nome do feriado deve ter pelo menos {{ limit }} caracteres.",
        maxMessage: "O nome do feriado não pode ter mais de {{ limit }} caracteres."
    )]
    public ?string $nome = null;

    #[Assert\NotBlank(message: "A data do feriado não pode estar em branco.")]
    #[Assert\Date(message: "A data do feriado deve estar no formato YYYY-MM-DD.")]
    public ?string $data = null;

    #[Assert\NotNull(message: "O nível do feriado não pode ser nulo.")]
    public ?FeriadoNivel $nivel = null;


    public function __construct(
        ?string $nome = null,
        ?string $data = null,
        ?FeriadoNivel $nivel = null

    ) {
        $this->nome = $nome;
        $this->data = $data;
        $this->nivel = $nivel;
    }
}
