<?php

namespace App\Identity\Application\Command;

final readonly class CreateUserCommand
{
    public function __construct(
        public string $email,
        public string $plainPassword,
    ) {
    }
}
