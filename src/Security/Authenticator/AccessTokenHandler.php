<?php

declare(strict_types=1);

namespace App\Security\Authenticator;

use App\Entity\Token;
use App\Exception\Security\InvalidAccessTokenException;
use App\Repository\TokenRepositoryInterface;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

class AccessTokenHandler implements AccessTokenHandlerInterface
{
    protected TokenRepositoryInterface $tokenRepository;

    public function __construct(TokenRepositoryInterface $tokenRepository)
    {
        $this->tokenRepository = $tokenRepository;
    }

    public function getUserBadgeFrom(string $accessToken): UserBadge
    {
        /** @var null|Token $token */
        $token = $this->tokenRepository->findOneBy(['token' => $accessToken]);

        if (null === $token) {
            throw new InvalidAccessTokenException();
        }

        return new UserBadge($token->getUser()->getUserIdentifier());
    }
}
