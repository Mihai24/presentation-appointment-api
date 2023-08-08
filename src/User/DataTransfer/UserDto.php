<?php

declare(strict_types=1);

namespace App\User\DataTransfer;

use App\DataTransfer\DataTransferObjectInterface;
use Symfony\Component\Validator\Constraints as Assert;

class UserDto implements DataTransferObjectInterface
{
    final public const PHONE_NUMBER_VALIDATION_REGEX = '/^\+?\d{10,20}/';

    #[Assert\NotBlank(allowNull: false)]
    #[Assert\Length(min: 3, max: 254)]
    public string $firstName;

    #[Assert\Length(min: 3, max: 254)]
    public string $lastName;

    #[Assert\NotBlank(allowNull: false)]
    #[Assert\Email]
    public string $email;

    #[Assert\NotBlank(allowNull: false)]
    #[Assert\Length(min: 4, max: 254)]
    public string $password;

    #[Assert\Length(min: 10, max: 20)]
    #[Assert\Regex(self::PHONE_NUMBER_VALIDATION_REGEX)]
    public ?string $phone = null;
}
