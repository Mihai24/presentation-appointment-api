<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Enrollment;
use App\Entity\Presentation;
use App\Entity\User;
use App\Tests\PropertyAccessTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

final class EnrollmentTest extends TestCase
{
    use PropertyAccessTrait;

    public function testAccessToObjectProperties(): void
    {
        $user = $this->createMock(User::class);
        $presentation = $this->createMock(Presentation::class);
        $uuid = $this->createMock(Uuid::class);

        $subject = new Enrollment($presentation, $user);

        $this->setProperty($subject, $uuid, 'id');

        $subject->onPrePersist();

        $this->assertInstanceOf(Uuid::class, $subject->getId());
        $this->assertInstanceOf(Presentation::class, $subject->getPresentation());
        $this->assertInstanceOf(User::class, $subject->getUser());
        $this->assertInstanceOf(\DateTimeImmutable::class, $subject->getCreatedAt());
    }
}
