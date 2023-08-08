<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Repository\UserRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
class GetAll
{
    #[Route('/api/users', name: 'app_users_get_all', methods: ['GET'])]
    public function __invoke(UserRepositoryInterface $userRepository, SerializerInterface $serializer): JsonResponse
    {
        return new JsonResponse(
            $serializer->serialize($userRepository->findAll(), 'json', ['groups' => ['user:read']]),
            Response::HTTP_OK,
            [],
            true
        );
    }
}
