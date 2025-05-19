<?php

namespace App\Tests\Entity\ValueObject;

use App\Entity\ValueObject\Cpf;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


final class CpflTest extends WebTestCase
{
    public function test_if_cpf_is_valid(): void
    {
        $cpf = new Cpf('43523797861');
        $this->assertEquals('43523797861', $cpf);
    }

    public function test_if_cpf_is_invalid(): void
    {    
        $this->expectException(\InvalidArgumentException::class);
    
        (new Cpf('111'));

        echo "Após instanciar Cpf\n";
    }

}
