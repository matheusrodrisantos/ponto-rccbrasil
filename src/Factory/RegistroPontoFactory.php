<?php

namespace App\Factory;

use App\Dto\RegistroPontoDTO;
use App\Entity\RegistroPonto;
use App\Entity\ValueObject\BatidaPonto;
use App\Repository\RegistroPontoRepository;
use DateTimeImmutable;

class RegistroPontoFactory
{
    public function __construct(
        private RegistroPontoRepository $departamentoRepository
    ) {}

    public function createFromDto(RegistroPontoDTO $dto): RegistroPonto
    {

        $batida = DateTimeImmutable::createFromFormat('H:i:s', $dto->horaBatida);

        $registroPonto = new RegistroPonto(new BatidaPonto($batida));

        if ($dto->funcionario !== null) {
            $registroPonto->atribuirFuncionario($dto->funcionario);
        }

        if ($dto->data !== null) {
            $registroPonto->ajustarDataPonto($dto->data);
        }

        return $registroPonto;
    }

    public function createDto(RegistroPonto $entity): RegistroPontoDTO
    {
        $dto = new RegistroPontoDTO();

        $dto->id = $entity->id();
        $dto->funcionario = $entity->funcionario();
        $dto->entrada = $entity->entrada();
        $dto->saida = $entity->saida();

        return $dto;
    }
}
