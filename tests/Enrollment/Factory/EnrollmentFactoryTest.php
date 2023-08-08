<?php

declare(strict_types=1);

namespace App\Tests\Enrollment\Factory;

use App\Enrollment\DataTransfer\EnrollmentDto;
use App\Enrollment\Factory\EnrollmentFactory;
use App\Entity\Enrollment;
use App\Entity\Presentation;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

final class EnrollmentFactoryTest extends TestCase
{
    public function testCreateEnrollmentFromDto(): void
    {
        $subject = new EnrollmentFactory();

        $user = $this->createMock(User::class);
        $presentation = $this->createMock(Presentation::class);
        $enrollmentDto = $this->createMock(EnrollmentDto::class);
        $enrollmentDto->presentation = $presentation;
        $enrollmentDto->user = $user;


        $this->assertInstanceOf(Enrollment::class, $subject->createFromDto($enrollmentDto));
    }
}