<?php

declare(strict_types=1);

namespace App\Controller\Presentation;

use App\Entity\User;
use App\Presentation\DataTransfer\PresentationDto;
use App\Presentation\Factory\PresentationFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsController]
final class Create
{
    #[Route('/api/presentations', name: 'app_presentations_create', methods: ['POST'])]
    public function __invoke(
        PresentationDto $presentationDto,
        PresentationFactoryInterface $presentationFactory,
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        #[CurrentUser] User $user
    ): JsonResponse {
        $presentationDto->organizer = $user;

        $violationList = $validator->validate($presentationDto);

        //todo add a violationHandler to return all errors

        $presentation = $presentationFactory->createFromDto($presentationDto);

        $entityManager->persist($presentation);
        $entityManager->flush();

        return new JsonResponse(
            $serializer->serialize($presentation, 'json', ['groups' => ['presentation:create', 'user:read']]),
            Response::HTTP_CREATED,
            [],
            true
        );
    }
}
