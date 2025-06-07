<?php

namespace App\Identity\Domain\ValueObject;

use App\Identity\Domain\Exception\InvalidEmailException;

final readonly class Email
{
    public function __construct(private string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException($value);
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
