<?php

namespace App\Identity\Domain\Model;

use App\Identity\Domain\ValueObject\UserId;
use App\Identity\Domain\ValueObject\Email;

final readonly class User
{
    private function __construct(
        private UserId $id,
        private Email $email,
        private ?string $hashedPassword = null,
        private array $roles = ['ROLE_USER'],
    ) {
    }

    public static function preRegister(Email $email): User
    {
        return new self(UserId::generate(), $email);
    }

    public static function register(User $user, string $hashedPassword): User
    {
        return new self($user->id, $user->email, $hashedPassword, $user->roles);
    }

    public static function fromPersistence(UserId $id, Email $email, string $hashedPassword, array $roles): self
    {
        return new self($id, $email, $hashedPassword, $roles);
    }

    public function getId(): UserId
    {
        return $this->id;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getHashedPassword(): string
    {
        return $this->hashedPassword
            ?? throw new \LogicException(sprintf('Password for user %s is not exists.', $this->email));
    }

    public function getRoles(): array
    {
        return $this->roles;
    }
}
