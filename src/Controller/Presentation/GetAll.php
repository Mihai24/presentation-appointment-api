<?php

declare(strict_types=1);

namespace App\Controller\Presentation;

use App\Repository\PresentationRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
final class GetAll
{
    #[Route('/api/presentations', name: 'app_presentations_get_all', methods: ['GET'])]
    public function __invoke(
        PresentationRepositoryInterface $presentationRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return new JsonResponse(
            $serializer->serialize(
                $presentationRepository->findAll(),
                'json',
                ['groups' => ['presentation:read', 'user:read']]
            ),
            Response::HTTP_OK,
            [],
            true
        );
    }
}
