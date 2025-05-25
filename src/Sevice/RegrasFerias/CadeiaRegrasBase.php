<?php

namespace App\Sevice\RegrasFerias;

use App\Dto\FeriasDTO;
use App\Sevice\RegrasFerias\RegrasFeriasInterface;

abstract class CadeiaRegrasBase implements RegrasFeriasInterface{

    private ?RegrasFeriasInterface $proximo = null;

    public function validar(FeriasDTO $ferias){
        if($this->proximo){

        }
    }

    public function proximo(RegrasFeriasInterface $regra){

    }


    


}