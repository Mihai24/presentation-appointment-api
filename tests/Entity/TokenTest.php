<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Token;
use PHPUnit\Framework\TestCase;
use App\Tests\PropertyAccessTrait;
use Symfony\Component\Security\Core\User\UserInterface;

final class TokenTest extends TestCase
{
    use PropertyAccessTrait;

    public function testAccessToObjectProperties(): void
    {
        $user = $this->createMock(UserInterface::class);

        $subject = new Token('1234', $user);

        $this->setProperty($subject, 1, 'id');

        $this->assertEquals(1, $subject->getId());
        $this->assertEquals('1234', $subject->getToken());
        $this->assertInstanceOf(\DateTimeImmutable::class, $subject->getCreatedAt());
        $this->assertInstanceOf(UserInterface::class, $subject->getUser());
    }
}
