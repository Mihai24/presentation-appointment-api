<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Entity\User;
use App\User\DataTransfer\UserDto;
use App\User\Factory\UserFactoryInterface;
use App\Validator\ViolationListHandlerTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsController]
class Update
{
    use ViolationListHandlerTrait;

    #[Route('/api/users/{id}', name: 'app_users_update', methods: ['PUT'])]
    #[IsGranted('update-user', 'user')]
    public function __invoke(
        UserDto $userDto,
        User $user,
        UserFactoryInterface $userFactory,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $userPasswordHasher
    ): JsonResponse {
        $violationList = $validator->validate($userDto);

        $this->handleViolationList($violationList);

        $user->update($userDto);

        $violationList->addAll($validator->validate($user));

        $this->handleViolationList($violationList);

        $user->setHashedPassword($user, $userPasswordHasher);
        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(
            $serializer->serialize($user, 'json', ['groups' => ['user:create']]),
            Response::HTTP_ACCEPTED,
            [],
            true
        );
    }
}
