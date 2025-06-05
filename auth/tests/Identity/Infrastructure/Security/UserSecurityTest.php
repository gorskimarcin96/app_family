<?php

namespace App\Tests\Identity\Infrastructure\Security;

use App\Identity\Domain\Model\User;
use App\Identity\Domain\ValueObject\Email;
use App\Identity\Infrastructure\Security\UserSecurity;
use PHPUnit\Framework\TestCase;

final class UserSecurityTest extends TestCase
{
    public function testSymfonyUserExposesDataCorrectly(): void
    {
        $user = User::preRegister(new Email('test@example.pl'));
        $symfonyUser = new UserSecurity($user);

        $this->assertSame((string)$user->getEmail(), $symfonyUser->getUserIdentifier());
        $this->assertSame($user->getRoles(), $symfonyUser->getRoles());
    }
}
