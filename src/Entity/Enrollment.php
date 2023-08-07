<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\EnrollmentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EnrollmentRepository::class)]
#[ORM\Table(name: 'enrollments')]
#[ORM\HasLifecycleCallbacks]
class Enrollment
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    protected Uuid $id;

    #[ORM\ManyToOne(targetEntity: Presentation::class, inversedBy: 'enrollments')]
    protected Presentation $presentation;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'enrollments')]
    protected User $user;

    #[ORM\Column(type: 'datetime', nullable: false)]
    #[Assert\Date]
    protected \DateTimeInterface $createdAt;

    public function __construct(Presentation $presentation, User $user)
    {
        $this->presentation = $presentation;
        $this->user = $user;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getPresentation(): Presentation
    {
        return $this->presentation;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }
}
