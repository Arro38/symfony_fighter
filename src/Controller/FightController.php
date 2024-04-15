<?php

namespace App\Controller;

use App\Entity\Fight;
use App\Entity\User;
use App\Entity\UserChampion;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
class FightController extends AbstractController
{
    #[Route('/fight/{id}', name: 'app_fight', methods: ['POST'])]
    public function fight(int $id, EntityManagerInterface $em): JsonResponse
    {
        $user1 = $this->getUser();
        $user2 = $em->getRepository(User::class)->find($id);

        if ($user1 === $user2) {
            return new JsonResponse(['error' => 'You cannot fight yourself'], 400);
        }

        if (!$user2) {
            return new JsonResponse(['error' => 'User not found'], 404);
        }

        $champion1 = $em->getRepository(UserChampion::class)->findOneBy(['user' => $user1]);
        $champion2 = $em->getRepository(UserChampion::class)->findOneBy(['user' => $user2]);

        if (!$champion1 || !$champion2) {
            return new JsonResponse(['error' => 'User has no champion'], 400);
        }
        $fight = new Fight();
        $fight->setUser1($user1);
        $fight->setUser2($user2);
        $fight->setCreatedAt(new \DateTimeImmutable());
        $em->persist($fight);

        $winner = null;
        $pv1 = $champion1->getPv();
        $pv2 = $champion2->getPv();
        $power1 = $champion1->getPower();
        $power2 = $champion2->getPower();

        while (!$winner) {
            if (rand(1, 2) == 1) {
                $attack1 = rand(1, $power1);
                $pv2 -= $attack1;
                if ($pv2 <= 0) {
                    $winner = $user1;
                    break;
                }
                $attack2 = rand(1, $power2);
                $pv1 -= $attack2;
                if ($pv1 <= 0) {
                    $winner = $user2;
                    break;
                }
            } else {
                $attack2 = rand(1, $power2);
                $pv1 -= $attack2;
                if ($pv1 <= 0) {
                    $winner = $user2;
                    break;
                }
                $attack1 = rand(1, $power1);
                $pv2 -= $attack1;
                if ($pv2 <= 0) {
                    $winner = $user1;
                    break;
                }
            }
        }

        $fight->setWinner($winner);
        $em->persist($fight);
        $em->flush();

        return new JsonResponse([
            'winner' => $winner->getUsername(),
        ]);
    }
}
