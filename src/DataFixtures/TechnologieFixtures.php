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
                'description' => 'HTML côté serveur, sans mélanger PHP et balises dans tous les sens.',
                'contenu' => "Ici, tout passe par templates/ : base.html.twig pose le menu, le footer et l’appel importmap('app'). Les pages comme home/index.html.twig ou technologie/show.html.twig n’écrasent que le bloc body.\n\nLes liens du menu utilisent path('app_home'), path('app_technologies'), etc. Si vous renommez une route dans un contrôleur, Twig regénère la bonne URL — pas de /hardcodé partout.\n\nLa fiche que vous lisez boucle sur technologie.contenu avec split et nl2br implicite via des paragraphes : typique du rendu Twig à partir de données Doctrine.",
            ],
            [
                'nom' => 'Routing',
                'slug' => 'routing',
                'description' => 'Une URL entrante → une méthode de contrôleur.',
                'contenu' => "Les routes sont des attributs #[Route(...)] sur src/Controller/*.php, pas un gros routing.yaml à maintenir à la main pour ces pages.\n\nExemple concret : /technologies/{slug} appelle TechnologieController::show() ; Symfony injecte la portion {slug} dans l’argument \$slug. Si le slug n’existe pas en base, createNotFoundException() renvoie une 404.\n\nHomeController expose aussi / → redirection 302 vers /home, pour ne pas rester sur la page skeleton à la racine. Liste complète : php bin/console debug:router.",
            ],
            [
                'nom' => 'Doctrine',
                'slug' => 'doctrine',
                'description' => 'Tables SQL vues comme des classes PHP (entités).',
                'contenu' => "Technologie et Message sont des entités dans src/Entity/, avec attributs ORM sur les propriétés. TechnologieController récupère la liste via getRepository(Technologie::class)->findAll() ; la fiche détail utilise findOneBy(['slug' => \$slug]).\n\nLe formulaire /message persist un Message après validation — toujours via EntityManagerInterface, sans SQL écrit à la main dans ce projet.\n\nLes textes des fiches Technologies viennent de TechnologieFixtures : après un git checkout demo/papy ou main, relancez doctrine:fixtures:load, sinon vous gardez l’ancien ton en base.",
            ],
            [
                'nom' => 'Formulaires',
                'slug' => 'form',
                'description' => 'Champs HTML + validation + lien vers une entité.',
                'contenu' => "MessageType (src/Form/) déclare les champs nom et contenu mappés sur l’entité Message. MessageController crée le form, handleRequest(\$request), puis teste isSubmitted() && isValid().\n\nLe template message/index.html.twig se contente de form_start, form_widget, form_end — Symfony génère les inputs et le token CSRF tant qu’on ne le désactive pas.\n\nC’est le flux classique « server-rendered » : POST, redirect après succès, flash message pour confirmer à l’utilisateur.",
            ],
            [
                'nom' => 'Autowiring',
                'slug' => 'autowiring',
                'description' => 'Type-hint dans le contrôleur → le conteneur fournit le service.',
                'contenu' => "Regardez les signatures : EntityManagerInterface dans TechnologieController, Request + MessageBusInterface dans MessageController. Aucun new EntityManager() ni fichier services.yaml dédié pour ça.\n\nSymfony matche le type au service enregistré. Ça vaut aussi pour les handlers Messenger : MessageEnvoyeHandler est repéré via #[AsMessageHandler].\n\nSi l’injection échoue un jour : php bin/console debug:autowiring EntityManagerInterface (ou le type qui pose problème).",
            ],
            [
                'nom' => 'Messenger',
                'slug' => 'messenger',
                'description' => 'Envoyer un « message » PHP à traiter à part de la réponse HTTP.',
                'contenu' => "Sur /message, une fois le Message flush en base, le contrôleur dispatch un MessageEnvoye contenant le texte saisi. Le handler (src/MessageHandler/MessageEnvoyeHandler.php) append ce texte dans var/messages.log.\n\nEn prod, le même bus enverrait plutôt un e-mail ou pousserait un job Redis/Rabbit — ici c’est volontairement visible dans un fichier pour la démo.\n\nL’intérêt : la page peut répondre tout de suite ; le traitement « annexe » ne bloque pas le temps de la requête web (selon config sync/async du transport).",
            ],
            [
                'nom' => 'Symfony Flex',
                'slug' => 'flex',
                'description' => 'composer require qui installe et configure une partie du projet.',
                'contenu' => "Quand on ajoute un package Symfony compatible, Flex applique souvent une recipe : config dans config/packages/, entrée dans symfony.lock, parfois enregistrement du bundle.\n\nCe dépôt a déjà Messenger, Doctrine, Form, WebProfiler, etc. — chaque brique est arrivée par des require plutôt qu’un copier-coller de config depuis la doc.\n\nsymfony.lock sert de trace : utile pour savoir quelles recipes ont déjà tourné sur ce skeleton.",
            ],
            [
                'nom' => 'Profiler',
                'slug' => 'profiler',
                'description' => 'Barre de debug en dev : une requête décortiquée.',
                'contenu' => "Avec APP_ENV=dev, chaque page affiche la Web Debug Toolbar. Vous y voyez la route app_technologie ou app_home, le contrôleur appelé, le temps, la mémoire, les requêtes Doctrine, les templates Twig rendus.\n\nUn clic sur le token ouvre /_profiler/… : pratique pour comprendre pourquoi /technologies déclenche N requêtes SQL ou quel template a été inclus.\n\nÀ ne pas exposer en production tel quel — c’est un outil développeur, pas une feature utilisateur.",
            ],
            [
                'nom' => 'AssetMapper',
                'slug' => 'assetmapper',
                'description' => 'JS et CSS via importmap, sans webpack obligatoire pour cette taille de projet.',
                'contenu' => "base.html.twig appelle {{ importmap('app') }} : le point d’entrée est assets/app.js, qui charge app.css et le bootstrap Stimulus.\n\nSur /technologies, data-controller=\"archive\" lie le bouton « Afficher / masquer » à archive_controller.js (toggle d’une classe .cache sur le bloc suivant).\n\nPas de npm run build pour faire tourner cette démo en local : vous éditez le JS, vous refresh (hors cache agressif du navigateur).",
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
