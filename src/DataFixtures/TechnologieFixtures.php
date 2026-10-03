<?php

namespace App\DataFixtures;

use App\Entity\Technologie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TechnologieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $technologies = [
    [
        'nom' => 'Twig',
        'slug' => 'twig',
        'description' => 'Le moteur de templates utilisé par Symfony.',
        'contenu' => 'Twig permet de créer des templates HTML propres et lisibles. Il propose des variables, des conditions, des boucles, des filtres et un système d’héritage.'
    ],
    [
        'nom' => 'Routing',
        'slug' => 'routing',
        'description' => 'Le système qui associe une URL à une action de contrôleur.',
        'contenu' => 'Le Routing permet à Symfony de déterminer quel contrôleur doit être exécuté lorsqu’une URL est appelée.'
    ],
    [
        'nom' => 'Doctrine',
        'slug' => 'doctrine',
        'description' => 'Un ORM permettant de gérer la base de données avec des objets PHP.',
        'contenu' => 'Doctrine permet de manipuler les données de la base de données sous forme d’objets PHP, sans devoir écrire directement toutes les requêtes SQL.'
    ],
    [
        'nom' => 'Autowiring',
        'slug' => 'autowiring',
        'description' => 'Le mécanisme qui permet à Symfony d’injecter automatiquement les dépendances.',
        'contenu' => 'Symfony analyse les dépendances nécessaires à une classe et les injecte automatiquement lorsqu’elles sont disponibles.'
    ],
    [
        'nom' => 'Messenger',
        'slug' => 'messenger',
        'description' => 'Un composant permettant notamment de traiter certaines tâches en arrière-plan.',
        'contenu' => 'Messenger permet de transmettre des messages et notamment de déléguer certaines tâches longues à un traitement en arrière-plan.'
    ],
    [
        'nom' => 'Symfony Flex',
        'slug' => 'flex',
        'description' => 'Un outil qui facilite l’installation et la configuration des fonctionnalités Symfony.',
        'contenu' => 'Symfony Flex automatise une partie de l’installation et de la configuration des packages Symfony grâce aux recettes.'
    ],
    [
        'nom' => 'Symfony Profiler',
        'slug' => 'profiler',
        'description' => 'Un outil de développement permettant d’observer et de déboguer l’application.',
        'contenu' => 'Le Profiler permet d’observer de nombreuses informations sur une requête : contrôleur utilisé, temps d’exécution, requêtes SQL, mémoire utilisée et bien plus.'
    ],
    [
        'nom' => 'Cache HTTP',
        'slug' => 'cache',
        'description' => 'Un mécanisme permettant de conserver certaines réponses pour améliorer les performances.',
        'contenu' => 'Le cache HTTP permet de conserver une réponse pendant une durée définie afin de pouvoir la servir plus rapidement lors des requêtes suivantes.'
    ],
];

        foreach ($technologies as $donnees) {
            $technologie = new Technologie();

            $technologie->setNom($donnees['nom']);
            $technologie->setSlug($donnees['slug']);
            $technologie->setDescription($donnees['description']);
            $technologie->setContenu($donnees['contenu']);
            
            $manager->persist($technologie);
        }

        $manager->flush();
    }
}