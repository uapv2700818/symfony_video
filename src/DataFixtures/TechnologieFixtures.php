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
                'description' => 'Moteur de templates : HTML séparé du PHP.',
                'contenu' => "Toutes les pages visibles passent par Twig. Le layout commun est dans base.html.twig (menu, footer, importmap). Chaque vue enfant n’override que le bloc body.\n\nLes URLs du menu sont générées avec path() et le nom de route Symfony, ce qui évite les liens codés en dur.\n\nC’est le mécanisme standard pour rendre du HTML côté serveur dans une application Symfony.",
            ],
            [
                'nom' => 'Routing',
                'slug' => 'routing',
                'description' => 'Association entre une URL et une action de contrôleur.',
                'contenu' => "Les routes sont déclarées en attributs PHP sur les méthodes des contrôleurs (convention recommandée depuis Symfony 6+).\n\nL’URL /technologies/{slug} illustre un paramètre dynamique : la valeur slug est injectée dans l’argument de la méthode show().\n\nLa commande debug:router liste l’ensemble des routes enregistrées — utile pour diagnostiquer une 404.",
            ],
            [
                'nom' => 'Doctrine',
                'slug' => 'doctrine',
                'description' => 'Persistance des données via des entités PHP.',
                'contenu' => "Les classes Technologie et Message sont mappées sur des tables SQL via les attributs ORM. Les contrôleurs utilisent EntityManagerInterface et les repositories pour lire et écrire.\n\nAucune requête SQL n’est construite à la main dans cette démo : findAll(), findOneBy(), persist() et flush() suffisent.\n\nLes jeux de données de test sont chargés avec doctrine:fixtures:load.",
            ],
            [
                'nom' => 'Formulaires',
                'slug' => 'form',
                'description' => 'Construction et validation des formulaires HTML.',
                'contenu' => "MessageType décrit les champs liés à l’entité Message. Le contrôleur instancie le formulaire, appelle handleRequest() puis vérifie isSubmitted() et isValid().\n\nLe template utilise form_start, form_widget et form_end. Le composant Form gère aussi la protection CSRF par défaut.\n\nC’est l’approche habituelle pour les formulaires server-rendered dans Symfony.",
            ],
            [
                'nom' => 'Autowiring',
                'slug' => 'autowiring',
                'description' => 'Injection automatique des services du conteneur.',
                'contenu' => "Les contrôleurs reçoivent Request, EntityManagerInterface ou MessageBusInterface en argument de méthode : Symfony résout le service correspondant au type hint.\n\nInutile d’instancier manuellement les services métier ou d’infrastructure dans ce projet.\n\nEn cas de doute sur un type, debug:autowiring indique comment le conteneur peut le fournir.",
            ],
            [
                'nom' => 'Messenger',
                'slug' => 'messenger',
                'description' => 'Bus de messages pour découpler le traitement.',
                'contenu' => "Après l’envoi du formulaire /message, le message est sauvegardé puis un objet MessageEnvoye est dispatché sur le bus.\n\nMessageEnvoyeHandler (attribut AsMessageHandler) append le contenu dans var/messages.log. En production, le même pattern servirait à envoyer un e-mail ou à pousser un job en queue.\n\nL’utilisateur reçoit une réponse HTTP rapidement ; le travail annexe est traité à part.",
            ],
            [
                'nom' => 'Symfony Flex',
                'slug' => 'flex',
                'description' => 'Installation et configuration guidée des packages.',
                'contenu' => "Composer require sur un package Symfony déclenche souvent une recipe Flex : fichiers de config, enregistrement de bundle, etc.\n\nLe fichier symfony.lock trace les recipes déjà appliquées dans le projet.\n\nFlex réduit le câblage manuel lors de l’ajout de composants.",
            ],
            [
                'nom' => 'Profiler',
                'slug' => 'profiler',
                'description' => 'Outils de debug en environnement de développement.',
                'contenu' => "Avec APP_ENV=dev, la Web Debug Toolbar apparaît en bas de chaque page. Elle résume le temps d’exécution, la route, le contrôleur, les requêtes Doctrine, les templates Twig utilisés, etc.\n\nUn clic ouvre l’interface /_profiler pour une analyse détaillée de la requête.\n\nCet outil ne doit pas être exposé tel quel en production.",
            ],
            [
                'nom' => 'AssetMapper',
                'slug' => 'assetmapper',
                'description' => 'Chargement des assets JavaScript et CSS sans pipeline complexe.',
                'contenu' => "Le layout appelle importmap('app'), point d’entrée défini dans importmap.php. assets/app.js importe les styles et enregistre les contrôleurs Stimulus.\n\nSur /technologies, archive_controller.js réagit au clic sur « Afficher / masquer » via data-controller et data-action.\n\nPour une démo de cette taille, aucun build front n’est obligatoire en local.",
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
