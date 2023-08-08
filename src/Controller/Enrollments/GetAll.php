<?php

declare(strict_types=1);

namespace App\Controller\Enrollments;

use App\Repository\EnrollmentRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
final class GetAll
{
    #[Route('/api/enrollments', name: 'app_enrollments_get_all', methods: ['GET'])]
    public function __invoke(
        EnrollmentRepositoryInterface $enrollmentRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return new JsonResponse(
            $serializer->serialize(
                $enrollmentRepository->findAll(),
                'json',
                ['groups' => ['enrollment:read', 'presentation:read', 'user:read']]
            ),
            Response::HTTP_OK,
            [],
            true
        );
    }
}
