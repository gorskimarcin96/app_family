<?php

namespace App\Identity\Domain\ValueObject;

use Ramsey\Uuid\Uuid;

final readonly class UserId
{
    public function __construct(private string $value)
    {
        if (!Uuid::isValid($value)) {
            throw new \InvalidArgumentException('Invalid UUID for UserId.');
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public static function generate(): self
    {
        return new self(Uuid::uuid4()->toString());
    }
}
