<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Presentation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PresentationRepository extends ServiceEntityRepository implements PresentationRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Presentation::class);
    }
}
