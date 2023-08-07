<?php

declare(strict_types=1);

namespace App\Security\Token;

use App\Entity\Token;
use Symfony\Component\Security\Core\User\UserInterface;

class TokenFactory implements TokenFactoryInterface
{
    protected const TOKEN_LENGTH = 15;

    public function create(UserInterface $user): Token
    {
        return new Token(\bin2hex(\random_bytes(self::TOKEN_LENGTH)), $user);
    }
}
