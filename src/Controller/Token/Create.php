<?php

declare(strict_types=1);

namespace App\Controller\Token;

use App\Entity\User;
use App\Security\Token\TokenFactoryInterface;
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
    #[Route('/api/tokens', name: 'app_tokens_create', methods: ['POST'])]
    public function __invoke(
        TokenFactoryInterface $tokenFactory,
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        #[CurrentUser] User $user
    ): JsonResponse {
        $token = $tokenFactory->create($user);

        $entityManager->persist($token);
        $entityManager->flush($token);

        return new JsonResponse(
            $serializer->serialize($token, 'json', ['groups' => 'token:read']),
            Response::HTTP_CREATED,
            [],
            true
        );
    }
}
