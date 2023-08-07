<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\User;
use App\Tests\PropertyAccessTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;

final class UserTest extends TestCase
{
    use PropertyAccessTrait;

    public function testAccessToObjectProperties(): void
    {
        $uuid = $this->createMock(Uuid::class);

        $subject = new User(
            'test@gmail.com',
            'First',
            'Last',
            'password',
            '0123456789'
        );

        $this->setProperty($subject, $uuid, 'id');

        $subject->onPrePersist();
        $subject->eraseCredentials();

        $this->assertInstanceOf(Uuid::class, $subject->getId());
        $this->assertEquals('test@gmail.com', $subject->getEmail());
        $this->assertEquals('test@gmail.com', $subject->getUserIdentifier());
        $this->assertEquals('First', $subject->getFirstName());
        $this->assertEquals('Last', $subject->getLastName());
        $this->assertEquals('0123456789', $subject->getPhone());
        $this->assertEquals('password', $subject->getPassword());
        $this->assertEquals([User::DEFAULT_USER_ROLE], $subject->getRoles());
        $this->assertInstanceOf(\DateTimeImmutable::class, $subject->getCreatedAt());
        $this->assertNull($subject->getUpdatedAt());
    }
}
