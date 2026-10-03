<?php

namespace App\Controller;

use App\Repository\TechnologieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\HttpKernel\Attribute\Cache;

class TechnologieController extends AbstractController
{
    #[Route('/technologies', name: 'app_technologies')]
    #[Cache(smaxage: 3600)]
    public function index(TechnologieRepository $repository): Response
    {
        $technologies = $repository->findAll();

        return $this->render('technologie/index.html.twig', [
            'technologies' => $technologies
        ]);
    }

    #[Route('/technologies/{slug}', name: 'app_technologie')]
    public function show(string $slug, TechnologieRepository $repository): Response
    {
        $technologie = $repository->findOneBy([
            'slug' => $slug
        ]);

        if (!$technologie) {
            throw $this->createNotFoundException('Technologie introuvable');
        }

        return $this->render('technologie/show.html.twig', [
            'technologie' => $technologie
        ]);
    }
}

