<?php

declare(strict_types=1);

namespace App\Controller\Enrollments;

use App\Entity\Enrollment;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
final class GetOne
{
    #[Route('/api/enrollments/{id}', name: 'app_enrollments_get_one', methods: ['GET'])]
    public function __invoke(
        Enrollment $enrollment,
        SerializerInterface $serializer
    ): JsonResponse {
        return new JsonResponse(
            $serializer->serialize(
                $enrollment,
                'json',
                ['groups' => ['enrollment:read', 'presentation:read', 'user:read']]
            ),
            Response::HTTP_OK,
            [],
            true
        );
    }
}
