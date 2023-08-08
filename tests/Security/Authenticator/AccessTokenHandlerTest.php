<?php

declare(strict_types=1);

namespace App\Tests\Security\Authenticator;

use App\Entity\Token;
use App\Exception\Security\InvalidAccessTokenException;
use App\Repository\TokenRepositoryInterface;
use App\Security\Authenticator\AccessTokenHandler;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

final class AccessTokenHandlerTest extends TestCase
{
    private TokenRepositoryInterface&MockObject $tokenRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tokenRepository = $this->createMock(TokenRepositoryInterface::class);
    }

    public function testGetUserBadge(): void
    {
        $subject = new AccessTokenHandler($this->tokenRepository);
        $token = $this->createMock(Token::class);
        $user = $this->createMock(UserInterface::class);

        $this->tokenRepository->expects($this->once())
            ->method('findOneBy')
            ->willReturn($token);

        $token->expects($this->once())
            ->method('getUser')
            ->willReturn($user);

        $user->expects($this->once())
            ->method('getUserIdentifier')
            ->willReturn('test@gmail.com');

        $this->assertInstanceOf(UserBadge::class, $subject->getUserBadgeFrom('123456'));
    }

    public function testGetUserBadgeWithNullToken(): void
    {
        $this->expectException(InvalidAccessTokenException::class);

        $this->tokenRepository->expects($this->once())
            ->method('findOneBy')
            ->willReturn(null);

        $subject = new AccessTokenHandler($this->tokenRepository);
        $subject->getUserBadgeFrom('123456');
    }
}
