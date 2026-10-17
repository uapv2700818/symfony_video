# Démo Symfony (vieux-programmeur)

Petit site pour **voir Symfony 8 en action** : routing, Twig, Doctrine, formulaires, Messenger, AssetMapper, profiler, etc. Même code partout ; seuls les textes changent selon la branche.

## Les deux versions

| Branche | Contenu |
|---------|---------|
| `main` (défaut) | Ton neutre, orienté découverte : ce que fait chaque brique dans **ce** projet. |
| `demo/papy` | Papy explique Symfony à ses petits-enfants (histoire + métaphores). |

```bash
git checkout demo/papy   # variante narrative uniquement
php bin/console doctrine:fixtures:load --no-interaction
```

Recharge les fixtures après un changement de branche : les textes des fiches « Technologies » viennent de la base.

## Prérequis

- PHP **8.4+** (extensions `ctype`, `iconv`)
- [Composer](https://getcomposer.org/)
- [Symfony CLI](https://symfony.com/download) (recommandé pour `symfony serve`)

## Installation

```bash
composer install
```

La base par défaut est **SQLite** (`var/data.db`), définie dans `.env` via `DATABASE_URL`.

```bash
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console doctrine:fixtures:load --no-interaction
```

## Lancer l’application

```bash
symfony serve -d
symfony open:local
```

Sans Symfony CLI :

```bash
php -S 127.0.0.1:8000 -t public/
```

URL utiles :

- http://127.0.0.1:8000/ → redirige vers `/home`
- `/histoire` (menu « Parcours » sur `main`) — vue d’ensemble du projet
- `/technologies` — fiches des composants
- `/message` — formulaire (Form + Doctrine + Messenger)

En `APP_ENV=dev`, la **Web Debug Toolbar** en bas de page ouvre le profiler (`/_profiler/…`).

## Commandes utiles

```bash
php bin/console debug:router
php bin/console lint:twig templates/
php bin/phpunit
```

## Structure rapide

- `src/Controller/` — routes (attributs `#[Route]`)
- `src/Entity/` — entités Doctrine
- `src/Form/` — formulaires
- `src/Message/` + `src/MessageHandler/` — Messenger
- `templates/` — Twig
- `assets/` — JS/CSS (AssetMapper + Stimulus)

Les messages envoyés depuis `/message` sont enregistrés en base et copiés dans `var/messages.log` par le handler.
