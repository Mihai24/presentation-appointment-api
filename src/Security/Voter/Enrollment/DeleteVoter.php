<?php

declare(strict_types=1);

namespace App\Security\Voter\Enrollment;

use App\Entity\Enrollment;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class DeleteVoter extends Voter
{
    public const DELETE_ENROLLMENT = 'delete-enrollment';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return $attribute === self::DELETE_ENROLLMENT && $subject instanceof Enrollment;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        /** @var Enrollment $subject */
        return $subject->getUser() === $user;
    }
}
