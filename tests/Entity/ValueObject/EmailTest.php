<?php

namespace App\Tests\Entity\ValueObject;

use App\Entity\ValueObject\Email;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


final class EmailTest extends WebTestCase
{
    public function test_if_email_is_valid(): void
    {
        $email = new Email('test@example.com');
        $this->assertEquals('test@example.com', $email->getEmail());
    }

    public function test_if_email_isnot_valid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid email address.');

        $email = new Email('Email invalido');

        echo "Após instanciar Email\n";
    }
}
