<?php

namespace App\Identity\Infrastructure\Doctrine\Mapper;

use App\Identity\Domain\Model\User;
use App\Identity\Domain\ValueObject\Email;
use App\Identity\Domain\ValueObject\UserId;
use App\Identity\Infrastructure\Doctrine\Entity\User as Entity;

final readonly class UserMapper
{
    public static function toDoctrine(User $domainUser): Entity
    {
        $doctrineUser = new Entity();
        $doctrineUser->setId($domainUser->getId());
        $doctrineUser->setEmail($domainUser->getEmail());
        $doctrineUser->setRoles($domainUser->getRoles());
        $doctrineUser->setPassword($domainUser->getHashedPassword());

        return $doctrineUser;
    }

    public static function toDomain(Entity $doctrineUser): User
    {
        return User::fromPersistence(
            new UserId($doctrineUser->getId()),
            new Email($doctrineUser->getEmail()),
            $doctrineUser->getPassword(),
            $doctrineUser->getRoles(),
        );
    }
}
