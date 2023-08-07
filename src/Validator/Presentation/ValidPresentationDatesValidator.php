<?php

declare(strict_types=1);

namespace App\Validator\Presentation;

use App\Presentation\DataTransfer\PresentationDto;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ValidPresentationDatesValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof ValidPresentationDates) {
            throw new UnexpectedTypeException($constraint, ValidPresentationDates::class);
        }

        if (!$value instanceof PresentationDto) {
            throw new UnexpectedValueException($value, PresentationDto::class);
        }

        if ($this->getDateTimeFromFormat($value->startsAt) < new \DateTimeImmutable('now')) {
            $this->context->buildViolation($constraint->startsAt)
                ->atPath('startsAt')
                ->addViolation();
        }

        if ($this->getDateTimeFromFormat($value->startsAt) >= $this->getDateTimeFromFormat($value->endsAt)) {
            $this->context->buildViolation($constraint->endsAt)
                ->atPath('endsAt')
                ->addViolation();
        }
    }

    protected function getDateTimeFromFormat(string $dateTime): \DateTimeImmutable
    {
        return \DateTimeImmutable::createFromFormat('d.m.Y H:i', $dateTime);
    }
}
