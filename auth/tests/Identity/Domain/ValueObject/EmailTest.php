<?php

namespace App\Tests\Identity\Domain\ValueObject;

use App\Identity\Domain\ValueObject\Email;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class EmailTest extends TestCase
{
    public function testValidEmail(): void
    {
        $email = new Email('user@example.com');

        $this->assertSame('user@example.com', (string)$email);
    }

    public function testInvalidEmail(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Email('invalid-email');
    }
}