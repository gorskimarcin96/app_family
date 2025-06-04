<?php

namespace App\Tests\Identity\Infrastructure\Security;

use App\Identity\Domain\Model\User;
use App\Identity\Domain\ValueObject\Email;
use App\Identity\Domain\ValueObject\UserId;
use App\Identity\Infrastructure\Security\UserSecurity;
use PHPUnit\Framework\TestCase;

final class UserSecurityTest extends TestCase
{
    public function testSymfonyUserExposesDataCorrectly(): void
    {
        $domainUser = new User(UserId::generate(), new Email('foo@bar.com'), 'password');
        $symfonyUser = new UserSecurity($domainUser);

        $this->assertSame((string)$domainUser->getEmail(), $symfonyUser->getUserIdentifier());
        $this->assertSame($domainUser->getPassword(), $symfonyUser->getPassword());
        $this->assertSame($domainUser->getRoles(), $symfonyUser->getRoles());
    }
}
