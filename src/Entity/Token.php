<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\TokenRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TokenRepository::class)]
#[ORM\Table(name: 'tokens')]
class Token
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('token:read')]
    protected int $id;

    #[ORM\Column(length: 255, nullable: false)]
    #[Assert\NotBlank(allowNull: false)]
    #[Groups('token:read')]
    protected string $token;

    #[ORM\Column(type: 'datetime', nullable: false)]
    #[Assert\NotBlank(allowNull: false)]
    #[Assert\Date]
    #[Groups('token:read')]
    protected \DateTimeInterface $createdAt;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'tokens')]
    protected UserInterface $user;

    public function __construct(string $token, UserInterface $user)
    {
        $this->token = $token;
        $this->user = $user;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }
}
