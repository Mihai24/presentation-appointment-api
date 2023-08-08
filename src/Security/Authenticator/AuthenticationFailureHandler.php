<?php

declare(strict_types=1);

namespace App\Security\Authenticator;

use App\Exception\Response\ErrorResponse;
use App\Exception\Security\InvalidAccessTokenException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;

class AuthenticationFailureHandler implements AuthenticationFailureHandlerInterface
{
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        return new ErrorResponse(new InvalidAccessTokenException());
    }
}
