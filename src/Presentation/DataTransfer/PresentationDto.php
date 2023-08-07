<?php

declare(strict_types=1);

namespace App\Presentation\DataTransfer;

use App\DataTransfer\DataTransferObjectInterface;
use App\Entity\User;
use App\Validator as CustomAssert;
use Symfony\Component\Validator\Constraints as Assert;

#[CustomAssert\Presentation\ValidPresentationDates]
class PresentationDto implements DataTransferObjectInterface
{
    #[Assert\NotBlank(allowNull: false)]
    #[Assert\Length(min: 3, max: 255)]
    public string $name;

    #[Assert\NotBlank(allowNull: false)]
    #[Assert\Length(min: 5, max: 1000)]
    public string $description;

    #[Assert\NotBlank(allowNull: false)]
    #[Assert\DateTime(format: 'd.m.Y H:i')]
    public string $startsAt;

    #[Assert\NotBlank(allowNull: false)]
    #[Assert\DateTime(format: 'd.m.Y H:i')]
    public string $endsAt;

    public ?User $organizer = null;
}
