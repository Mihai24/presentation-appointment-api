<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Enrollment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EnrollmentRepository extends ServiceEntityRepository implements EnrollmentRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Enrollment::class);
    }
}
