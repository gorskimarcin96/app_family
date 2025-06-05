<?php

namespace App\Tests\Identity\UI\Http\Controller;

use App\Identity\Domain\ValueObject\UserId;
use App\Identity\Infrastructure\Doctrine\Entity\User;
use App\Identity\Infrastructure\Doctrine\Mapper\UserMapper;
use App\Identity\Infrastructure\Security\UserSecurity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

abstract class AbstractControllerWebTestCase extends WebTestCase
{
    private ?KernelBrowser $client = null;

    protected function setUp(): void
    {
        parent::setUp();

        $client = $this->getApiClient();
        $em = $client->getContainer()->get(EntityManagerInterface::class);
        $hasher = $client->getContainer()->get(UserPasswordHasherInterface::class);

        $email = 'test@example.com';
        $password = 'password';
        $user = $em->getRepository(User::class)->findOneBy(['email' => $email])
            ?? (new User())->setId(UserId::generate())->setEmail($email)->setPassword($password);

        $securityUser = new UserSecurity(UserMapper::toDomain($user));
        $user->setPassword($hasher->hashPassword($securityUser, $password));

        $em->persist($user);
        $em->flush();
    }

    protected function getApiClient(): KernelBrowser
    {
        if (!$this->client) {
            $this->client = static::createClient();
        }

        return $this->client;
    }

    protected function getJwtToken(): string
    {
        $this->getApiClient()->request(
            method: 'POST',
            uri: '/api/login',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode(['email' => 'test@example.com', 'password' => 'password']),
        );

        return json_decode($this->getApiClient()->getResponse()->getContent(), true)['token'];
    }
}
