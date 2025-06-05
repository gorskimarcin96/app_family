<?php

namespace App\Tests\Identity\Application\Handler;

use App\Identity\Application\Command\CreateUserCommand;
use App\Identity\Application\Handler\CreateUserHandler;
use App\Identity\Domain\Model\User;
use App\Identity\Domain\Repository\UserRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Identity\Infrastructure\Security\UserSecurity;

final class CreateUserHandlerTest extends TestCase
{
    public function testItCreatesUserAndSavesToRepository(): void
    {
        $email = 'test@example.com';
        $plainPassword = 'plainPassword';
        $hashedPassword = 'hashedPassword';
        $command = new CreateUserCommand($email, $plainPassword);

        $repository = $this->createMock(UserRepositoryInterface::class);
        $passwordHasher = $this->createMock(UserPasswordHasherInterface::class);

        $passwordHasher->expects($this->once())
            ->method('hashPassword')
            ->with($this->isInstanceOf(UserSecurity::class), $plainPassword)
            ->willReturn($hashedPassword);

        $repository->expects($this->once())
            ->method('save')
            ->with(
                $this->callback(
                    fn(User $user): bool => (string)$user->getEmail() === $email
                        && $user->getHashedPassword() === $hashedPassword,
                ),
            );

        $handler = new CreateUserHandler($repository, $passwordHasher);
        $handler($command);
    }
}
