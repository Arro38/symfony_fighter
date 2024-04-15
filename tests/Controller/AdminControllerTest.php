<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{
    public function testGetChampions(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['username' => 'testAdmin']);
        $client->loginUser($testUser);
        $client->request('GET', '/admin/champions');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
    }

    public function testGetChampion(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['username' => 'testAdmin']);
        $client->loginUser($testUser);
        $client->request('GET', '/admin/champion/1');
        $this->assertResponseStatusCodeSame(200);
    }

    public function testCreateChampion(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['username' => 'testAdmin']);
        $client->loginUser($testUser);
        $client->request('POST', '/admin/champion', [], [], [], json_encode([
            'name' => 'Champion',
            'pv' => 100,
            'power' => 10,
        ]));

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
    }

    public function testCreateChampionInvalidRole(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['username' => 'testUser']);
        $client->loginUser($testUser);
        $client->request('POST', '/admin/champion', [], [], [], json_encode([
            'name' => 'Champion2',
            'pv' => 100,
            'power' => 10,
        ]));

        $this->assertResponseStatusCodeSame(403);
    }

    public function testGetChampionNotFound(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['username' => 'testAdmin']);
        $client->loginUser($testUser);
        $client->request('GET', '/admin/champion/100');

        $this->assertResponseStatusCodeSame(404);
    }

    public function testUpdateChampion(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['username' => 'testAdmin']);
        $client->loginUser($testUser);
        $client->request('PUT', '/admin/champion/1', [], [], [], json_encode([
            'name' => 'Champion',
            'pv' => 100,
            'power' => 10,
        ]));

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
    }

    public function testDeleteChampion(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['username' => 'testAdmin']);
        $client->loginUser($testUser);
        $client->request('DELETE', '/admin/champion/4');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
    }
}
