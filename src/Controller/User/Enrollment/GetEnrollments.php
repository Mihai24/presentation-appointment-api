<?php

declare(strict_types=1);

namespace App\Controller\User\Enrollment;

use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
class GetEnrollments
{
    #[Route('/api/users/{id}/enrollments', name: 'app_users_get_enrollments', methods: ['GET'])]
    public function __invoke(User $user, SerializerInterface $serializer): JsonResponse
    {
        return new JsonResponse(
            $serializer->serialize(
                $user->getEnrollments(),
                'json',
                ['groups' => ['user:read', 'enrollments:read']]
            ),
            Response::HTTP_OK,
            [],
            true
        );
    }
}
