<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FightControllerTest extends WebTestCase
{
    public function testFight(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['username' => 'testUser']);
        $client->loginUser($testUser);
        $client->request('POST', '/api/fight/3');
        $this->assertResponseIsSuccessful();
        $this->assertJsonStringEqualsJsonString('{"winner":"testUser"}', $client->getResponse()->getContent());
    }
}
