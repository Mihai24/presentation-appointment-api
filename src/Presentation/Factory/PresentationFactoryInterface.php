<?php

declare(strict_types=1);

namespace App\Presentation\Factory;

use App\Entity\Presentation;
use App\Presentation\DataTransfer\PresentationDto;

interface PresentationFactoryInterface
{
    public function createFromDto(PresentationDto $presentationDto): Presentation;
}
