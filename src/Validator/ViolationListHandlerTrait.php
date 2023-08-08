<?php

declare(strict_types=1);

namespace App\Validator;

use App\Exception\Http\BadRequestException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

trait ViolationListHandlerTrait
{
    public function handleViolationList(ConstraintViolationListInterface $constraintViolationList): void
    {
        if (0 === $constraintViolationList->count()) {
            return;
        }

        $errorList = [];

        foreach ($constraintViolationList as $violation) {
            $errorList[$violation->getPropertyPath()][] = $violation->getMessage();
        }

        throw new BadRequestException($errorList);
    }
}
