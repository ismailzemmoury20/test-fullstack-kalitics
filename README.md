# Test Technique Symfony - Pointages

## Prérequis

- Docker Desktop
- PHP 8.2
- Composer
- Symfony CLI

## Installation

```bash
docker compose up -d
composer install
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
symfony serve
```

L'application tourne sur `http://127.0.0.1:8000`

## Outils utilisés pendant la phase de développement

- `php bin/console make:entity` pour générer l'entité ClockingItem
- `php bin/console doctrine:migrations:diff` pour générer les migrations


## Ce que j'ai fait

**Partie 1** : J'ai créé une entité `ClockingItem` pour séparer les lignes chantier/durée du pointage principal. Le formulaire utilise le `CollectionType` Symfony pour permettre d'ajouter plusieurs chantiers dynamiquement en JavaScript.

**Partie 2** : Un formulaire avec un multi-select de collaborateurs permet au chef de projet de pointer plusieurs personnes en une seule soumission. Le controller crée autant de `Clocking` que de collaborateurs sélectionnés.

## Base de données

PostgreSQL via Docker. La `DATABASE_URL` dans `.env` est déjà configurée.