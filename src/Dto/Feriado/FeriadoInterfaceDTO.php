<?php
namespace App\Dto\Feriado;

use App\Entity\Enum\FeriadoNivel;

interface FeriadoInterfaceDTO {

    public function getNome(): ?string;

    public function getData(): ?string;

    public function getNivel(): ?FeriadoNivel;

    public function isRecorrente(): ?bool;
}
