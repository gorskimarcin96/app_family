<?php

namespace App\Tests\Identity\Infrastructure\Doctrine\Mapper;

use App\Identity\Domain\Model\User;
use App\Identity\Domain\ValueObject\Email;
use App\Identity\Domain\ValueObject\UserId;
use App\Identity\Infrastructure\Doctrine\Entity\User as Entity;
use App\Identity\Infrastructure\Doctrine\Mapper\UserMapper;
use PHPUnit\Framework\TestCase;

final class UserMapperTest extends TestCase
{
    public function testDomainToDoctrine(): void
    {
        $domainUser = User::fromPersistence(
            UserId::generate(),
            new Email('test@example.pl'),
            'password',
            ['ROLE_USER'],
        );
        $entity = UserMapper::toDoctrine($domainUser);

        $this->assertInstanceOf(Entity::class, $entity);
        $this->assertSame((string)$domainUser->getId(), $entity->getId());
        $this->assertSame((string)$domainUser->getEmail(), $entity->getEmail());
        $this->assertSame($domainUser->getHashedPassword(), $entity->getPassword());
        $this->assertSame($domainUser->getRoles(), $entity->getRoles());
    }

    public function testDoctrineToDomain(): void
    {
        $entity = new Entity();
        $entity->setId((string)UserId::generate());
        $entity->setEmail('admin@example.com');
        $entity->setPassword('hashed');
        $entity->setRoles(['ROLE_ADMIN']);

        $domainUser = UserMapper::toDomain($entity);

        $this->assertInstanceOf(User::class, $domainUser);
        $this->assertSame($entity->getId(), (string)$domainUser->getId());
        $this->assertSame($entity->getEmail(), (string)$domainUser->getEmail());
        $this->assertSame($entity->getPassword(), $domainUser->getHashedPassword());
        $this->assertSame($entity->getRoles(), $domainUser->getRoles());
    }
}
