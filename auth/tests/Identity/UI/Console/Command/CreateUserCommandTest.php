<?php

namespace App\Tests\Identity\UI\Console\Command;

use App\Identity\Domain\Repository\UserRepositoryInterface;
use App\Identity\Domain\ValueObject\Email;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Console\Application;
use App\Identity\UI\Console\Command\CreateUserCommand;

final class CreateUserCommandTest extends KernelTestCase
{
    public function testCreateUserSuccessfully(): void
    {
        self::bootKernel();

        $application = new Application();
        $command = static::getContainer()->get(CreateUserCommand::class);

        $application->add($command);
        $commandTester = new CommandTester($command);

        $email = 'cli@example.com';
        $commandTester->execute(['email' => $email, 'password' => 'password']);

        $commandTester->assertCommandIsSuccessful();
        $this->assertStringContainsString("User {$email} created.", $commandTester->getDisplay());

        /** @var UserRepositoryInterface $userRepository */
        $userRepository = static::getContainer()->get(UserRepositoryInterface::class);
        $user = $userRepository->findByEmail(new Email($email));

        $this->assertNotNull($user);
        $this->assertSame($email, (string)$user->getEmail());

        $userRepository->delete($user);
    }
}
