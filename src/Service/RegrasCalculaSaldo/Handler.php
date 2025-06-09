<?php
namespace App\Service\RegrasCalculaSaldo;

use App\Dto\FuncionarioDTO;

interface Handler
{

    public function podeLidar():bool;

    public function proximo(Handler $handler):Handler;

    public function lidar();
}
