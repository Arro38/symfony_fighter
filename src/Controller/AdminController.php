<?php

namespace App\Controller;

use App\Entity\Champion;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/champions', name: 'app_get_champions', methods: ['GET'])]
    public function app_get_champions(EntityManagerInterface $em): JsonResponse
    {
        // Champions is an array of Champion with findAll
        $champions = $em->getRepository(Champion::class)->findAll();

        $championsArray = [];

        foreach ($champions as $champion) {
            $championsArray[] = [
                'id' => $champion->getId(),
                'name' => $champion->getName(),
                'pv' => $champion->getPv(),
                'power' => $champion->getPower(),
            ];
        }

        return new JsonResponse($championsArray);
    }

    #[Route('/champion/{id}', name: 'app_get_champion', methods: ['GET'])]
    public function app_get_champion(int $id, EntityManagerInterface $em): JsonResponse
    {
        $champion = $em->getRepository(Champion::class)->find($id);

        if (!$champion) {
            return new JsonResponse(['error' => "Champion not found with id $id"], 404);
        }

        return new JsonResponse([
            'id' => $champion->getId(),
            'name' => $champion->getName(),
            'pv' => $champion->getPv(),
            'power' => $champion->getPower(),
        ]);
    }

    #[Route('/champion', name: 'app_create_champion', methods: ['POST'])]
    public function app_create_champion(EntityManagerInterface $em, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $name = $data['name'];
        $pv = $data['pv'];
        $power = $data['power'];

        if (empty($name) || empty($pv) || empty($power)) {
            return new JsonResponse(['error' => 'Invalid request'], 400);
        }

        $champion = new Champion();
        $champion->setName($name);
        $champion->setPv($pv);
        $champion->setPower($power);

        $em->persist($champion);
        $em->flush();

        return new JsonResponse([
            'id' => $champion->getId(),
            'name' => $champion->getName(),
            'pv' => $champion->getPv(),
            'power' => $champion->getPower(),
        ]);
    }

    #[Route('/champion/{id}', name: 'app_update_champion', methods: ['PUT'])]
    public function app_update_champion(EntityManagerInterface $em, Request $request, int $id): JsonResponse
    {
        $champion = $em->getRepository(Champion::class)->find($id);
        if (!$champion) {
            return new JsonResponse(['error' => 'Champion not found'], 404);
        }

        $data = json_decode($request->getContent(), true);
        $name = $data['name'];
        $pv = $data['pv'];
        $power = $data['power'];

        if (empty($name) || empty($pv) || empty($power)) {
            return new JsonResponse(['error' => 'Invalid request'], 400);
        }

        $champion->setName($name);
        $champion->setPv($pv);
        $champion->setPower($power);

        $em->flush();

        return new JsonResponse([
            'id' => $champion->getId(),
            'name' => $champion->getName(),
            'pv' => $champion->getPv(),
            'power' => $champion->getPower(),
        ]);
    }

    #[Route('/champion/{id}', name: 'app_delete_champion', methods: ['DELETE'])]
    public function app_delete_champion(EntityManagerInterface $em, int $id): JsonResponse
    {
        $champion = $em->getRepository(Champion::class)->find($id);
        if (!$champion) {
            return new JsonResponse(['error' => 'Champion not found'], 404);
        }

        $em->remove($champion);
        $em->flush();

        return new JsonResponse(['message' => 'Champion deleted']);
    }
}
