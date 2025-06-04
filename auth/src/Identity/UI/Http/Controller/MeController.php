<?php

namespace App\Identity\UI\Http\Controller;

use App\Identity\Domain\Repository\UserRepositoryInterface;
use App\Identity\Domain\ValueObject\Email;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class MeController extends AbstractController
{
    #[Route('/api/me', name: 'auth_me', methods: ['GET'])]
    public function __invoke(UserRepositoryInterface $userRepository): JsonResponse
    {
        if (null !== $loggedUser = $this->getUser()) {
            $user = $userRepository->findByEmail(new Email($loggedUser->getUserIdentifier()));
        }

        return $loggedUser && isset($user) ? $this->json(
            [
                'id' => (string)$user->getId(),
                'email' => (string)$user->getEmail(),
                'roles' => $user->getRoles(),
            ],
        ) : $this->json(['error' => 'Unauthorized'], 401);
    }
}
