<?php 
namespace App\Sevice\RegrasDepartamento;

use App\Dto\DepartamentoDTO;

interface RegrasDepartamentoInterface{
    public function validar(DepartamentoDTO $departamentoDTO) : void;

}