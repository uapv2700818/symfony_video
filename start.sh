#!/bin/bash
GREEN='\033[0;32m'
BLUE='\033[0;34m'
NC='\033[0;3m'

# On détecte automatiquement le nom du service PHP de Symfony (souvent 'web', 'app' ou 'php')
# Si 'app' existe dans le compose.yaml, on l'utilise, sinon on se rabat sur 'web'
if grep -q "app:" compose.yaml compose.override.yaml 2>/dev/null; then
  SERVICE_NAME="app"
else
  SERVICE_NAME="web"
fi

echo -e "${BLUE}[1/4] Démarrage des conteneurs officiels de Symfony...${NC}"
docker compose up -d

echo -e "${BLUE}[2/4] Installation des dépendances Composer dans le conteneur...${NC}"
# On utilise temporairement l'image globale si votre conteneur n'a pas PHP pour installer
docker compose exec -T $SERVICE_NAME composer install 2>/dev/null || docker run --rm -v $(pwd):/app -w /app composer install

echo -e "${BLUE}[3/4] Configuration de la base de données...${NC}"
docker compose exec -T $SERVICE_NAME php bin/console doctrine:database:create --if-not-exists --no-interaction 2>/dev/null || true
docker compose exec -T $SERVICE_NAME php bin/console doctrine:migrations:migrate --no-interaction

echo -e "${BLUE}[4/4] Chargement des données de test (Fixtures)...${NC}"
docker compose exec -T $SERVICE_NAME php bin/console doctrine:fixtures:load --no-interaction

echo -e "${GREEN}==================================================${NC}"
echo -e "${GREEN} Tout est configuré via Docker !${NC}"
echo -e "${GREEN} Vous pouvez utiliser 'symfony server:start' ou${NC}"
echo -e "${GREEN} vérifier le port exposé par votre conteneur.${NC}"
echo -e "${GREEN}==================================================${NC}"
