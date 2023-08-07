<?php

declare(strict_types=1);

namespace App\Validator\Presentation;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class ValidPresentationDates extends Constraint
{
    public string $startsAt = 'The start date should not be less than the current time';

    public string $endsAt = 'The end date should be higher than the start date';

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
