<?php

namespace App\Identity\Application\Handler;

use App\Identity\Application\Command\CreateUserCommand;
use App\Identity\Domain\Model\User;
use App\Identity\Domain\Repository\UserRepositoryInterface;
use App\Identity\Domain\ValueObject\Email;
use App\Identity\Infrastructure\Security\UserSecurity;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class CreateUserHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserPasswordHasherInterface $hasher,
    ) {
    }

    public function __invoke(CreateUserCommand $command): void
    {
        $preRegister = User::preRegister(new Email($command->email));
        $password = $this->hasher->hashPassword(new UserSecurity($preRegister), $command->plainPassword);
        $user = User::register($preRegister, $password);

        $this->userRepository->save($user);
    }
}
