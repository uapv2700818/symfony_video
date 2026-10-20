#!/bin/bash
GREEN='\033[0;32m'
BLUE='\033[0;34m'
NC='\033[0;3m'

echo -e "${BLUE}[1/4] Construction et démarrage du conteneur Docker...${NC}"
docker compose up -d --build

echo -e "${BLUE}[2/4] Installation des dépendances Composer...${NC}"
docker compose exec web composer install

echo -e "${BLUE}[3/4] Configuration de la base de données SQLite...${NC}"
docker compose exec web mkdir -p var
docker compose exec web chmod -R 777 var
docker compose exec web php bin/console doctrine:database:create --if-not-exists --no-interaction
docker compose exec web php bin/console doctrine:migrations:migrate --no-interaction

echo -e "${BLUE}[4/4] Chargement des données de test (Fixtures)...${NC}"
docker compose exec web php bin/console doctrine:fixtures:load --no-interaction

echo -e "${GREEN}==================================================${NC}"
echo -e "${GREEN} Tout est prêt ! L'application est disponible sur :${NC}"
echo -e "${GREEN} http://localhost:8000${NC}"
echo -e "${GREEN}==================================================${NC}"
