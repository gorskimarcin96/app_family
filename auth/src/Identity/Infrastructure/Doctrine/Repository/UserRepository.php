<?php

namespace App\Identity\Infrastructure\Doctrine\Repository;

use App\Identity\Domain\Model\User;
use App\Identity\Domain\Repository\UserRepositoryInterface;
use App\Identity\Domain\ValueObject\Email;
use App\Identity\Infrastructure\Doctrine\Entity\User as Entity;
use App\Identity\Infrastructure\Doctrine\Mapper\UserMapper;
use Doctrine\ORM\EntityManagerInterface;

final readonly class UserRepository implements UserRepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function save(User $user): void
    {
        $this->entityManager->persist(UserMapper::toDoctrine($user));
        $this->entityManager->flush();
    }

    public function delete(User $user): void
    {
        $this->entityManager
            ->getRepository(Entity::class)
            ->createQueryBuilder('u')
            ->where('u.email = :email')
            ->setParameter('email', $user->getEmail())
            ->delete()
            ->getQuery()
            ->execute();
    }

    public function findByEmail(Email $email): ?User
    {
        $user = $this->entityManager
            ->getRepository(Entity::class)
            ->findOneBy(['email' => $email]);

        return $user ? UserMapper::toDomain($user) : null;
    }
}
