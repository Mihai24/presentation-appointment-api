<?php

declare(strict_types=1);

namespace App\Security\Authenticator;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\AccessToken\AccessTokenExtractorInterface;

class ApiKeyTokenExtractor implements AccessTokenExtractorInterface
{
    public const HEADER_TOKEN_KEY = 'X-APP-TOKEN';

    public function extractAccessToken(Request $request): ?string
    {
        $token = $request->headers->get(self::HEADER_TOKEN_KEY);

        if (null === $token) {
            throw new AccessDeniedException();
        }

        return $token;
    }
}
