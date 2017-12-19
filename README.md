# Betting System

This is my PHP project. It is a betting system, where a user can register and login, and place bets for current matches.

## Commands
php ../demo/bin/console doctrine:generate:entities AppBundle/Entity/Team

php ../demo/bin/console doctrine:generate:entities AppBundle/Entity/Bet

php ../demo/bin/console doctrine:generate:entities AppBundle/Entity/Match

php ../demo/bin/console doctrine:generate:entities AppBundle/Entity/User


php ../demo/bin/console doctrine:schema:drop --force --full-database

php ../demo/bin/console doctrine:database:create

php ../demo/bin/console doctrine:schema:update --force

php ../demo/bin/console doctrine:fixtures:load --no-interaction

php ../demo/bin/console cache:clear

php ../demo/bin/console server:run
