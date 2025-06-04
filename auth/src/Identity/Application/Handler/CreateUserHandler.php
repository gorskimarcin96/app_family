<?php

namespace App\Identity\Application\Handler;

use App\Identity\Application\Command\CreateUserCommand;
use App\Identity\Domain\Model\User;
use App\Identity\Domain\Repository\UserRepositoryInterface;
use App\Identity\Domain\ValueObject\Email;
use App\Identity\Domain\ValueObject\UserId;
use App\Identity\Infrastructure\Security\UserSecurity;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class CreateUserHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function __invoke(CreateUserCommand $command): void
    {
        $email = new Email($command->email);
        $user = new User(UserId::generate(), $email, '');
        $hashedPassword = $this->passwordHasher->hashPassword(new UserSecurity($user), $command->plainPassword);
        $userWithPassword = new User($user->getId(), $email, $hashedPassword);

        $this->userRepository->save($userWithPassword);
    }
}
