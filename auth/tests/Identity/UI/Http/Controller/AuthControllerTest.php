<?php

namespace App\Tests\Identity\UI\Http\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

final class AuthControllerTest extends AbstractControllerWebTestCase
{
    public function testLoginSuccess(): void
    {
        $this->getApiClient()->request(
            method: 'POST',
            uri: '/api/login',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode(['email' => 'test@example.com', 'password' => 'password']),
        );

        self::assertResponseIsSuccessful();

        $data = json_decode($this->getApiClient()->getResponse()->getContent(), true);
        $this->assertArrayHasKey('token', $data);
        $this->assertNotEmpty($data['token']);
    }

    public function testLoginInvalidPassword(): void
    {
        $this->getApiClient()->request(
            method: 'POST',
            uri: '/api/login',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode(['email' => 'test@example.com', 'password' => 'wrong-password']),
        );

        self::assertResponseStatusCodeSame(JsonResponse::HTTP_UNAUTHORIZED);
    }

    public function testLoginInvalidEmail(): void
    {
        $this->getApiClient()->request(
            method: 'POST',
            uri: '/api/login',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode(['email' => 'invalid.email', 'password' => 'password']),
        );

        self::assertResponseStatusCodeSame(JsonResponse::HTTP_BAD_REQUEST);
    }

    public function testLoginNotExistsEmail(): void
    {
        $this->getApiClient()->request(
            method: 'POST',
            uri: '/api/login',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode(['email' => 'not@exists.com', 'password' => 'password']),
        );

        self::assertResponseStatusCodeSame(JsonResponse::HTTP_UNAUTHORIZED);
    }

}
