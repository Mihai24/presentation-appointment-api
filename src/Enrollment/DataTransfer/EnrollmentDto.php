<?php

declare(strict_types=1);

namespace App\Enrollment\DataTransfer;

use App\DataTransfer\DataTransferObjectInterface;
use App\Entity\Presentation;
use App\Entity\User;

class EnrollmentDto implements DataTransferObjectInterface
{
    public ?Presentation $presentation = null;

    public ?User $user = null;
}
