<?php

declare(strict_types=1);

namespace App\User\Factory;

use App\Entity\User;
use App\User\DataTransfer\UserDto;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFactory implements UserFactoryInterface
{
    protected UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function createFromDto(UserDto $userDto): User
    {
        $user = new User(
            $userDto->email,
            $userDto->firstName,
            $userDto->lastName,
            $userDto->password
        );

        $user->setHashedPassword($user, $this->userPasswordHasher);

        return $user;
    }
}
