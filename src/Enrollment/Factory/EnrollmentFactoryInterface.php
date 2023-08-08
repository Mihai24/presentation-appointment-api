<?php

declare(strict_types=1);

namespace App\Enrollment\Factory;

use App\Enrollment\DataTransfer\EnrollmentDto;
use App\Entity\Enrollment;

interface EnrollmentFactoryInterface
{
    public function createFromDto(EnrollmentDto $enrollmentDto): Enrollment;
}
