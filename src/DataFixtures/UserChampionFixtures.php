<?php

namespace App\DataFixtures;

use App\Entity\Champion;
use App\Entity\User;
use App\Entity\UserChampion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserChampionFixtures

extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $userChampion = new UserChampion();
        $user = $manager->getRepository(User::class)->find(2);
        $champion = $manager->getRepository(Champion::class)->find(1);
        $userChampion->setUser($user)
            ->setChampion($champion)
            ->setPv(random_int(100, 200))
            ->setPower(random_int(10, 20));
        $manager->persist($userChampion);

        $userChampion = new UserChampion();
        $user = $manager->getRepository(User::class)->find(3);
        $champion = $manager->getRepository(Champion::class)->find(2);
        $userChampion->setUser($user)
            ->setChampion($champion)
            ->setPv(random_int(100, 200))
            ->setPower(random_int(10, 20));
        $manager->persist($userChampion);
        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            ChampionFixtures::class,
            UserFixtures::class
        ];
    }
}
