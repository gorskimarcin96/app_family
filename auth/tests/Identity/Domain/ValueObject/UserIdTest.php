<?php

namespace App\Tests\Identity\Domain\ValueObject;

use App\Identity\Domain\ValueObject\UserId;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class UserIdTest extends TestCase
{
    public function testValidUserCustomId(): void
    {
        $uuid = 'f44ce305-1090-4eef-aa70-1a13a456b27c';

        $this->assertSame($uuid, (string)new UserId($uuid));
    }

    public function testValidUserGenerateId(): void
    {
        $this->assertTrue(Uuid::isValid((string)UserId::generate()));
    }

    public function testInvalidUserId(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new UserId('invalid-uuid');
    }
}
