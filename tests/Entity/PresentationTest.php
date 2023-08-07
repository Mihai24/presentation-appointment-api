<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Presentation;
use App\Entity\User;
use App\Tests\PropertyAccessTrait;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

final class PresentationTest extends TestCase
{
    use PropertyAccessTrait;

    public function testAccessToObjectProperties(): void
    {
        $dateTime = $this->createMock(\DateTimeImmutable::class);
        $organizer = $this->createMock(User::class);
        $uuid = $this->createMock(Uuid::class);

        $subject = new Presentation('test', 'test description', $dateTime, $dateTime, $organizer);

        $this->setProperty($subject, $uuid, 'id');

        $subject->onPrePersist();

        $this->assertInstanceOf(Uuid::class, $subject->getId());
        $this->assertEquals('test', $subject->getName());
        $this->assertEquals('test description', $subject->getDescription());
        $this->assertInstanceOf(\DateTimeImmutable::class, $subject->getStartsAt());
        $this->assertInstanceOf(\DateTimeImmutable::class, $subject->getEndsAt());
        $this->assertInstanceOf(ArrayCollection::class, $subject->getEnrollments());
        $this->assertInstanceOf(User::class, $subject->getOrganizer());
        $this->assertInstanceOf(\DateTimeImmutable::class, $subject->getCreatedAt());
        $this->assertNull($subject->getUpdatedAt());
    }
}
