<?php

declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

trait SoftDeleteTrait
{
    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Groups(['soft-delete:read'])]
    protected ?\DateTimeInterface $deletedAt = null;

    public function delete(): void
    {
        if (null !== $this->getDeletedAt()) {
            return;
        }

        $this->deletedAt = new \DateTimeImmutable();
    }

    public function getDeletedAt(): \DateTimeInterface
    {
        return $this->deletedAt;
    }
}
