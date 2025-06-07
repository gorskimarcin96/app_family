<?php

namespace App\Identity\Infrastructure\Security;

use App\Identity\Domain\Exception\InvalidEmailException;
use App\Identity\Domain\Repository\UserRepositoryInterface;
use App\Identity\Domain\ValueObject\Email;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final readonly class UserSecurityProvider implements UserProviderInterface
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        try {
            $user = $this->userRepository->findByEmail(new Email($identifier));
        } catch (InvalidEmailException $exception) {
            throw new BadRequestException($exception->getMessage());
        }

        return $user
            ? new UserSecurity($user)
            : throw new UserNotFoundException(sprintf('User "%s" not found.', $identifier));
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        return $user;
    }

    public function supportsClass(string $class): bool
    {
        return $class === UserSecurity::class;
    }
}
