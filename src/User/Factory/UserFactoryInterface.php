<?php

declare(strict_types=1);

namespace App\User\Factory;

use App\Entity\User;
use App\User\DataTransfer\UserDto;

interface UserFactoryInterface
{
    public function createFromDto(UserDto $userDto): User;
}
