<?php

declare(strict_types=1);

namespace App\Security\Voter\User;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class UpdateVoter extends Voter
{
    public const UPDATE_USER = 'update-user';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return $attribute === self::UPDATE_USER && $subject instanceof UserInterface;
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
