<?php

declare(strict_types=1);

namespace App\Controller\Enrollments;

use App\Enrollment\DataTransfer\EnrollmentDto;
use App\Enrollment\Factory\EnrollmentFactoryInterface;
use App\Entity\Presentation;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
final class Create
{
    #[Route('/api/presentations/{id}/enrollment', name: 'app_presentations_enrollment_creat', methods: ['POST'])]
    public function __invoke(
        Presentation $presentation,
        EnrollmentDto $enrollmentDto,
        EnrollmentFactoryInterface $enrollmentFactory,
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        #[CurrentUser] User $user
    ): JsonResponse {
        $enrollmentDto->user = $user;
        $enrollmentDto->presentation = $presentation;
        $enrollment = $enrollmentFactory->createFromDto($enrollmentDto);

        $entityManager->persist($enrollment);
        $entityManager->flush();

        return new JsonResponse(
            $serializer->serialize(
                $enrollment,
                'json',
                ['groups' => ['user:read', 'presentation:read', 'enrollment:creat']]
            ),
            Response::HTTP_CREATED,
            [],
            true
        );
    }
}
