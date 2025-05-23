<?php

namespace App\Sevice\RegrasFerias;

use App\Dto\FeriasDTO;
use App\Sevice\RegrasFerias\RegrasFeriasInterface;

abstract class CadeiaRegrasBase implements RegrasFeriasInterface{

    private ?RegrasFeriasInterface $proximo = null;

    public function validar(FeriasDTO $ferias){
        


    }

    public function proximo(RegrasFeriasInterface $regra){

    }

    public function handle(string $request): void {
        if ($this->proximo) {
            $this->proximo->handle($request);
        }
    }

    


}