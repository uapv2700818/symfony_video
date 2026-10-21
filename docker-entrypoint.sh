#!/bin/sh
set -e

composer install --no-interaction --prefer-dist

php bin/console importmap:install
php bin/console assets:install public

php bin/console doctrine:migrations:migrate --no-interaction

exec php -S 0.0.0.0:8000 -t public/