<?php

declare(strict_types=1);

namespace App\Controller\Presentation;

use App\Entity\Presentation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[AsController]
final class Delete
{
    #[Route('/api/presentations/{id}', name: 'app_presentations_delete', methods: ['DELETE'])]
    #[IsGranted('presentation_delete', 'presentation')]
    public function __invoke(Presentation $presentation, EntityManagerInterface $entityManager): JsonResponse
    {
        $presentation->delete();
        $entityManager->flush();

        return new JsonResponse(null, Response::HTTP_ACCEPTED, [], true);
    }
}
