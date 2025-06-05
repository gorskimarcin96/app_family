<?php

namespace App\Tests\Identity\Domain\Model;

use App\Identity\Domain\Model\User;
use App\Identity\Domain\ValueObject\Email;
use App\Identity\Domain\ValueObject\UserId;
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    public function testUserFromPreRegister(): void
    {
        $email = new Email('test@example.com');

        $user = User::preRegister($email);

        $this->assertSame($email, $user->getEmail());
        $this->assertEquals(['ROLE_USER'], $user->getRoles());
    }

    public function testUserFromRegister(): void
    {
        $email = new Email('test@example.com');
        $password = 'hashed_password';

        $user = User::register(User::preRegister($email), $password);

        $this->assertSame($email, $user->getEmail());
        $this->assertIsString($user->getHashedPassword());
        $this->assertEquals(['ROLE_USER'], $user->getRoles());
    }

    public function testUserFromDatabase(): void
    {
        $id = new UserId('64c8acf0-2a18-4c7d-b164-a5d0d3048b8e');
        $email = new Email('admin@example.com');
        $password = 'admin_pass';
        $roles = ['ROLE_ADMIN', 'ROLE_USER'];

        $user = User::fromPersistence($id, $email, $password, $roles);

        $this->assertSame($id, $user->getId());
        $this->assertSame($email, $user->getEmail());
        $this->assertSame($password, $user->getHashedPassword());
        $this->assertEquals($roles, $user->getRoles());
    }
}
