<?php

namespace App\Tests\Identity\Domain\Model;

use App\Identity\Domain\Model\User;
use App\Identity\Domain\ValueObject\Email;
use App\Identity\Domain\ValueObject\UserId;
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    public function testUserIsCreatedWithDefaults(): void
    {
        $id = UserId::generate();
        $email = new Email('test@example.com');
        $password = 'hashed_password';

        $user = new User($id, $email, $password);

        $this->assertSame($id, $user->getId());
        $this->assertSame($email, $user->getEmail());
        $this->assertSame($password, $user->getPassword());
        $this->assertEquals(['ROLE_USER'], $user->getRoles());
    }

    public function testUserIsCreatedWithCustomData(): void
    {
        $id = new UserId('64c8acf0-2a18-4c7d-b164-a5d0d3048b8e');
        $email = new Email('admin@example.com');
        $password = 'admin_pass';
        $roles = ['ROLE_ADMIN', 'ROLE_USER'];

        $user = new User($id, $email, $password, $roles);

        $this->assertSame($id, $user->getId());
        $this->assertSame($email, $user->getEmail());
        $this->assertSame($password, $user->getPassword());
        $this->assertEquals($roles, $user->getRoles());
    }
}
