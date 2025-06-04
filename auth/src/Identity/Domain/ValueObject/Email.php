<?php

namespace App\Identity\Domain\ValueObject;

final readonly class Email
{
    public function __construct(private string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid email');
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
