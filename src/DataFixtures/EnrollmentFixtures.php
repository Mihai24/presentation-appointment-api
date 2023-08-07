<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Enrollment;
use App\Entity\Presentation;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class EnrollmentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        /** @var User $user */
        $user = $this->getReference(UserFixtures::USER_REFERENCE);
        /** @var Presentation $presentation */
        $presentation = $this->getReference(PresentationFixtures::PRESENTATION_REFERENCE);

        $enrollment = new Enrollment($presentation, $user);

        $manager->persist($enrollment);
        $manager->flush($enrollment);
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            PresentationFixtures::class
        ];
    }
}
