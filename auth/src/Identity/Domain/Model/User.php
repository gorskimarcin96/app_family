<?php

namespace App\Identity\Domain\Model;

use App\Identity\Domain\ValueObject\UserId;
use App\Identity\Domain\ValueObject\Email;

final readonly class User
{
    public function __construct(
        private UserId $id,
        private Email $email,
        private string $password,
        private array $roles = ['ROLE_USER'],
    ) {
    }

    public function getId(): UserId
    {
        return $this->id;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }
}
