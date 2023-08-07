<?php

declare(strict_types=1);

namespace App\Presentation\Factory;

use App\Entity\Presentation;
use App\Presentation\DataTransfer\PresentationDto;

class PresentationFactory implements PresentationFactoryInterface
{
    public function createFromDto(PresentationDto $presentationDto): Presentation
    {
        return new Presentation(
            $presentationDto->name,
            $presentationDto->description,
            $this->getDateTimeFromFormat($presentationDto->startsAt),
            $this->getDateTimeFromFormat($presentationDto->endsAt),
            $presentationDto->organizer
        );
    }

    protected function getDateTimeFromFormat(string $dateTime): \DateTimeImmutable
    {
        return \DateTimeImmutable::createFromFormat('d.m.Y H:i', $dateTime);
    }
}
