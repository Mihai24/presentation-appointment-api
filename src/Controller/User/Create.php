<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\User\DataTransfer\UserDto;
use App\User\Factory\UserFactoryInterface;
use App\Validator\ViolationListHandlerTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsController]
class Create
{
    use ViolationListHandlerTrait;

    #[Route('/api/users', name: 'app_users_create', methods: ['POST'])]
    public function __invoke(
        UserDto $userDto,
        UserFactoryInterface $userFactory,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $violationList = $validator->validate($userDto);

        $this->handleViolationList($violationList);

        $user = $userFactory->createFromDto($userDto);

        $violationList->addAll($validator->validate($user));

        $this->handleViolationList($violationList);

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(
            $serializer->serialize($user, 'json', ['groups' => ['user:create']]),
            Response::HTTP_CREATED,
            [],
            true
        );
    }
}
