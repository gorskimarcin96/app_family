<?php

namespace App\Identity\Infrastructure\Security;

use App\Identity\Domain\Model\User;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final readonly class UserSecurity implements UserInterface, PasswordAuthenticatedUserInterface
{
    public function __construct(private User $user)
    {
    }

    public function getUserIdentifier(): string
    {
        return (string)$this->user->getEmail();
    }

    public function getRoles(): array
    {
        return $this->user->getRoles();
    }

    public function getPassword(): string
    {
        return $this->user->getHashedPassword();
    }

    public function eraseCredentials(): void
    {
    }
}
