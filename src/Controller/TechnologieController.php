<?php

namespace App\Controller;

use App\Entity\Technologie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TechnologieController extends AbstractController
{
    #[Route('/technologies', name: 'app_technologies')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $technologies = $entityManager
            ->getRepository(Technologie::class)
            ->findAll();

        return $this->render('technologie/index.html.twig', [
            'technologies' => $technologies,
        ]);
    }

    #[Route('/technologies/{slug}', name: 'app_technologie')]
    public function show(
        string $slug,
        EntityManagerInterface $entityManager
    ): Response {
        $technologie = $entityManager
            ->getRepository(Technologie::class)
            ->findOneBy(['slug' => $slug]);

        if (!$technologie) {
            throw $this->createNotFoundException();
        }

        return $this->render('technologie/show.html.twig', [
            'technologie' => $technologie,
        ]);
    }
}
