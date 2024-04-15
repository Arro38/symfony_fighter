<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail("testAdmin@gmail.com")
            ->setPassword(password_hash("password", PASSWORD_DEFAULT))
            ->setUsername("testAdmin")
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        $user = new User();
        $user->setEmail("testUser@gmail.com")
            ->setPassword(password_hash("password", PASSWORD_DEFAULT))
            ->setUsername("testUser");
        $manager->persist($user);

        $user = new User();
        $user->setEmail("testUser2@gmail.com")
            ->setPassword(password_hash("password", PASSWORD_DEFAULT))
            ->setUsername("testUser2");
        $manager->persist($user);

        $manager->flush();
    }
}
