<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PresentationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PresentationRepository::class)]
#[ORM\Table(name: 'presentations')]
#[ORM\HasLifecycleCallbacks]
class Presentation
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    protected Uuid $id;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: false)]
    #[Assert\NotBlank(allowNull: false)]
    #[Assert\Length(min: 3, max: 255)]
    protected string $name;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\NotBlank(allowNull: false)]
    #[Assert\Length(min: 5, max: 1000)]
    protected string $description;

    #[ORM\Column(type: 'datetime', nullable: false)]
    #[Assert\NotBlank(allowNull: false)]
    #[Assert\Date]
    protected \DateTimeInterface $startsAt;

    #[ORM\Column(type: 'datetime', nullable: false)]
    #[Assert\NotBlank(allowNull: false)]
    #[Assert\Date]
    protected \DateTimeInterface $endsAt;

    #[ORM\Column(type: 'datetime', nullable: false)]
    #[Assert\Date]
    protected \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Assert\Date]
    protected ?\DateTimeInterface $updatedAt = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'programs')]
    protected User $organizer;

    #[ORM\OneToMany(mappedBy: 'presentation', targetEntity: Enrollment::class)]
    protected Collection $enrollments;

    public function __construct(
        string $name,
        string $description,
        \DateTimeInterface $startsAt,
        \DateTimeInterface $endsAt,
        User $organizer
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->startsAt = $startsAt;
        $this->endsAt = $endsAt;
        $this->organizer = $organizer;
        $this->enrollments = new ArrayCollection();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function getStartsAt(): \DateTimeInterface
    {
        return $this->startsAt;
    }

    public function getEndsAt(): \DateTimeInterface
    {
        return $this->endsAt;
    }

    public function getEnrollments(): Collection
    {
        return $this->enrollments;
    }

    public function getOrganizer(): User
    {
        return $this->organizer;
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }
}
