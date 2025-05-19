<?php

namespace App\Entity\ValueObject;
use InvalidArgumentException;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Email
{
    #[ORM\Column(type: "string")]
    private string $email;

    public function __construct(string $email)
    {
        if (!$this->isValid($email)) {
            throw new InvalidArgumentException("Invalid email address.");
        }
        $this->email = $email;
    }

    public function __toString(): string
    {
        return $this->email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    private function isValid(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}