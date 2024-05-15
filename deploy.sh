#!/bin/bash

composer install
chmod -R 777 storage 
php artisan migrate:fresh --seed 
php artisan L5-swagger:generate