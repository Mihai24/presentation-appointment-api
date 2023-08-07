<?php

declare(strict_types=1);

namespace App\Controller\Presentation;

use App\Entity\Presentation;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
final class GetOne
{
    #[Route('/api/presentations/{id}', 'app_presentations_get_one', methods: ['GET'])]
    public function __invoke(Presentation $presentation, SerializerInterface $serializer): JsonResponse
    {
        return new JsonResponse(
            $serializer->serialize($presentation, 'json', ['groups' => ['presentation:read', 'user:read']]),
            Response::HTTP_OK,
            [],
            true
        );
    }
}
