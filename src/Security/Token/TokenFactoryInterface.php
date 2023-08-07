<?php

declare(strict_types=1);

namespace App\Security\Token;

use App\Entity\Token;
use Symfony\Component\Security\Core\User\UserInterface;

interface TokenFactoryInterface
{
    public function create(UserInterface $user): Token;
}
