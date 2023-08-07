<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
#[UniqueEntity('email')]
#[ORM\HasLifecycleCallbacks]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    final public const DEFAULT_USER_ROLE = 'ROLE_USER';

    final public const ADMIN_USER_ROLE = 'ROLE_ADMIN';

    final public const PHONE_NUMBER_VALIDATION_REGEX = '/^\+?\d{10,20}/';

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    protected Uuid $id;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    #[Assert\NotBlank(allowNull: false)]
    #[Assert\Length(min: 3, max: 254)]
    protected string $firstName;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    #[Assert\NotBlank(allowNull: false)]
    #[Assert\Length(min: 3, max: 254)]
    protected string $lastName;

    #[ORM\Column(type: 'string', length: 255, unique: true, nullable: false)]
    #[Assert\NotBlank(allowNull: false)]
    #[Assert\Email]
    protected string $email;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    #[Assert\NotBlank(allowNull: false)]
    #[Assert\Length(min: 4, max: 254)]
    protected string $password;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(min: 10, max: 20)]
    #[Assert\Regex(self::PHONE_NUMBER_VALIDATION_REGEX)]
    protected ?string $phone = null;

    #[ORM\Column(type: 'datetime', nullable: false)]
    protected \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    protected ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(type: 'json')]
    #[Assert\All(new Assert\Choice(choices: [self::DEFAULT_USER_ROLE, self::ADMIN_USER_ROLE]))]
    protected array $roles = [User::DEFAULT_USER_ROLE];

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Token::class)]
    protected Collection $tokens;

    public function __construct(
        string $email,
        string $firstName,
        string $lastName,
        string $password,
        ?string $phone = null
    ) {
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phone = $phone;
        $this->password = $password;
        $this->tokens = new ArrayCollection();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function getTokens(): Collection
    {
        return $this->tokens;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setHashedPassword(User $user, UserPasswordHasherInterface $userPasswordHasher): void
    {
        $this->password = $userPasswordHasher->hashPassword($user, $user->getPassword());;
    }
}
