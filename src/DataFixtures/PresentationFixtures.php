<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Presentation;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class PresentationFixtures extends Fixture implements DependentFixtureInterface
{
    public const PRESENTATION_REFERENCE = 'presentation-reference';

    public function load(ObjectManager $manager): void
    {
        /** @var User $user */
        $user = $this->getReference(UserFixtures::USER_REFERENCE);
        $presentation = new Presentation(
            'First presentation',
            'A short description',
            new \DateTimeImmutable('2023-08-01 12:30:00'),
            new \DateTimeImmutable('2023-08-01 14:00:00'),
            $user
        );

        $manager->persist($presentation);
        $manager->flush();

        $this->addReference(self::PRESENTATION_REFERENCE, $presentation);
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class
        ];
    }
}
