<?php

namespace App\Domain\ValueObjects;

class Email
{
    private string $email;

    public function __construct(string $email)
    {
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

    public function isEqualTo(self $other): bool
    {
        return strtolower($this->email) === strtolower($other->getEmail());
    }

    public function validate(): bool
    {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL) !== false;
    }
}
