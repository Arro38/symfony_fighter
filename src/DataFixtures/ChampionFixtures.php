<?php

namespace App\DataFixtures;

use App\Entity\Champion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ChampionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $championNames = [
            'Garen',
            'Darius',
            'Teemo',
            'Jinx',
            'Yasuo',
            'Zed',
            'Lux',
            'Ahri',
            'Janna',
            'Soraka',
        ];

        foreach ($championNames as $championName) {
            $champion = new Champion();
            $champion->setName($championName)
                ->setPv(random_int(100, 200))
                ->setPower(random_int(10, 20));
            $manager->persist($champion);
        }

        $manager->flush();
    }
}
