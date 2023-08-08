<?php

declare(strict_types=1);

namespace App\Controller\Enrollments;

use App\Entity\Enrollment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[AsController]
final class Delete
{
    #[Route('/api/enrollments/{id}', name: 'app_enrollments_delete', methods: ['DELETE'])]
    #[IsGranted('enrollment_delete', 'enrollment')]
    public function __invoke(Enrollment $enrollment, EntityManagerInterface $entityManager): JsonResponse
    {
        $enrollment->delete();
        $entityManager->flush();

        return new JsonResponse(null, Response::HTTP_ACCEPTED, [], true);
    }
}
