#!/bin/bash

docker-compose down &&
git pull &&
docker-compose up -d &&
docker exec avia-back_app composer install &&
docker exec avia-back_app chmod -R 777 storage &&
docker exec avia-back_app php artisan migrate:fresh --seed &&
# docker exec avia-back_app php artisan L5-swagger:generate
