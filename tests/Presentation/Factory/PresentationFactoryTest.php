<?php

declare(strict_types=1);

namespace App\Tests\Presentation\Factory;

use App\Entity\Presentation;
use App\Entity\User;
use App\Presentation\DataTransfer\PresentationDto;
use App\Presentation\Factory\PresentationFactory;
use PHPUnit\Framework\TestCase;

final class PresentationFactoryTest extends TestCase
{
    public function testCreatePresentationFromDto(): void
    {
        $subject = new PresentationFactory();

        $user = $this->createMock(User::class);
        $presentationDto = $this->createMock(PresentationDto::class);
        $presentationDto->name = 'presentation';
        $presentationDto->description = 'description';
        $presentationDto->startsAt = '01.05.2023 15:30';
        $presentationDto->endsAt = '01.05.2023 16:30';
        $presentationDto->organizer = $user;

        $this->assertInstanceOf(Presentation::class, $subject->createFromDto($presentationDto));
    }
}
