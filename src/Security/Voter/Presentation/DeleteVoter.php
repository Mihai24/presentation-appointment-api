<?php

declare(strict_types=1);

namespace App\Security\Voter\Presentation;

use App\Entity\Presentation;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class DeleteVoter extends Voter
{
    public const DELETE_PRESENTATION = 'delete-presentation';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return $attribute === self::DELETE_PRESENTATION && $subject instanceof Presentation;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        /** @var Presentation $subject */
        return $subject->getOrganizer() === $user;
    }
}
