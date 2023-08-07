<?php

declare(strict_types=1);

namespace App\Tests\Security\Provider;

use App\Entity\Token;
use App\Entity\User;
use App\Security\Provider\UserProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class UserProviderTest extends TestCase
{
    private UserProviderInterface&MockObject $emailUserProvider;

    protected function setUp(): void
    {
        parent::setUp();

        $this->emailUserProvider = $this->createMock(UserProviderInterface::class);
    }

    public function testLoadingUserByIdentifierWithUserNotFoundInDatabase(): void
    {
        $this->expectException(UserNotFoundException::class);

        $this->emailUserProvider->expects($this->once())
            ->method('loadUserByIdentifier')
            ->with('id')
            ->willThrowException(new UserNotFoundException());

        $subject = new UserProvider($this->emailUserProvider);
        $subject->loadUserByIdentifier('id');
    }

    public function testSupports(): void
    {
        $subject = new UserProvider($this->emailUserProvider);

        $this->assertTrue($subject->supportsClass(User::class));
        $this->assertFalse($subject->supportsClass(Token::class));
    }

    public function testRefreshUser(): void
    {
        $subject = new UserProvider($this->emailUserProvider);
        $user = $this->createMock(User::class);

        $this->assertSame($user, $subject->refreshUser($user));
    }
}
