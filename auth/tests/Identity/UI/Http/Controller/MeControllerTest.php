<?php

namespace App\Tests\Identity\UI\Http\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

final class MeControllerTest extends AbstractControllerWebTestCase
{
    public function testMeSuccess(): void
    {
        $this->getApiClient()->request(
            method: 'GET',
            uri: '/api/me',
            server: ['HTTP_Authorization' => 'Bearer ' . $this->getJwtToken()],
        );

        self::assertResponseIsSuccessful();

        $data = json_decode($this->getApiClient()->getResponse()->getContent(), true);

        $this->assertIsString($data['id']);
        $this->assertEquals('test@example.com', $data['email']);
        $this->assertEquals(['ROLE_USER'], $data['roles']);
    }

    public function testMeUnauthorized(): void
    {
        $this->getApiClient()->request(
            method: 'GET',
            uri: '/api/me',
        );

        self::assertResponseStatusCodeSame(JsonResponse::HTTP_UNAUTHORIZED);
    }
}
