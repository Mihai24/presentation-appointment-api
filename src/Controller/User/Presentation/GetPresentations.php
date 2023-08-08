<?php

declare(strict_types=1);

namespace App\Controller\User\Presentation;

use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
final class GetPresentations
{
    #[Route('/api/users/{id}/presentations', name: 'app_users_get_presentations', methods: ['GET'])]
    public function __invoke(User $user, SerializerInterface $serializer): JsonResponse
    {
        return new JsonResponse(
            $serializer->serialize(
                $user->getPresentations(),
                'json',
                ['groups' => ['user:read', 'presentation:read']]
            ),
            Response::HTTP_OK,
            [],
            true
        );
    }
}
