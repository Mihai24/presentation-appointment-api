<?php

namespace App\Controller\User;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[AsController]
class Delete
{
    #[Route('/api/users/{id}', name: 'app_users_delete', methods: ['DELETE'])]
    #[IsGranted('delete-user', 'user')]
    public function __invoke(User $user, EntityManagerInterface $entityManager): JsonResponse
    {
        $user->delete();
        $entityManager->flush();

        return new JsonResponse(null, Response::HTTP_ACCEPTED);
    }
}
