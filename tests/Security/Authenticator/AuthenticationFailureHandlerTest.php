<?php

declare(strict_types=1);

namespace App\Tests\Security\Authenticator;

use App\Exception\Response\ErrorResponse;
use App\Exception\Security\InvalidAccessTokenException;
use App\Security\Authenticator\AuthenticationFailureHandler;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

final class AuthenticationFailureHandlerTest extends TestCase
{
    public function testOnAuthenticationFailure(): void
    {
        $subject = new AuthenticationFailureHandler();
        $request = $this->createMock(Request::class);
        $authException = $this->createMock(AuthenticationException::class);

        $this->assertEquals(
            new ErrorResponse(new InvalidAccessTokenException()),
            $subject->onAuthenticationFailure($request, $authException)
        );
    }
}
