<?php

declare(strict_types=1);

namespace App\Enrollment\Factory;

use App\Enrollment\DataTransfer\EnrollmentDto;
use App\Entity\Enrollment;

class EnrollmentFactory implements EnrollmentFactoryInterface
{
    public function createFromDto(EnrollmentDto $enrollmentDto): Enrollment
    {
        return new Enrollment(
            $enrollmentDto->presentation,
            $enrollmentDto->user
        );
    }
}
