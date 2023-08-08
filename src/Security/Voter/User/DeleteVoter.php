<?php

declare(strict_types=1);

namespace App\Security\Voter\User;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class DeleteVoter extends Voter
{
    public const DELETE_USER = 'delete-user';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return $attribute === self::DELETE_USER && $subject instanceof UserInterface;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        /** @var UserInterface $subject */
        return $subject->getUserIdentifier() === $user->getUserIdentifier();
    }
}
