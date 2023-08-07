<?php

declare(strict_types=1);

namespace App\Security\Provider;

use App\Entity\User;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    protected UserProviderInterface $emailUserProvider;

    public function __construct(
        #[Autowire(service: 'security.user.provider.concrete.email')]
        UserProviderInterface $emailUserProvider
    ) {
        $this->emailUserProvider = $emailUserProvider;
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        return $user;
    }

    public function supportsClass(string $class): bool
    {
        return User::class === $class || \is_subclass_of($class, User::class);
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        return $this->emailUserProvider->loadUserByIdentifier($identifier);
    }
}
