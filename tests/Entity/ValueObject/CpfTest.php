<?php

namespace App\Tests\Entity\ValueObject;



use App\Entity\ValueObject\Cpf;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Faker\Factory;

final class CpfTest extends WebTestCase
{
    public function test_if_cpf_is_valid(): void
    {
        $faker = Factory::create('pt_BR');

        $cpfFaker = $faker->cpf(false);
        $cpf = new Cpf($cpfFaker);
        $this->assertEquals($cpfFaker, $cpf);
    }

    public function test_if_cpf_is_invalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new Cpf('111'));

        echo "Após instanciar Cpf\n";
    }
}
