<?php

declare(strict_types=1);

namespace App\Tests\Security\Token;

use App\Entity\Token;
use App\Entity\User;
use App\Security\Token\TokenFactory;
use PHPUnit\Framework\TestCase;

final class TokenFactoryTest extends TestCase
{
    public function testCreateToken(): void
    {
        $subject = new TokenFactory();
        $user = $this->createMock(User::class);

        $this->assertInstanceOf(Token::class, $subject->create($user));
    }
}
