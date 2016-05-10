#!/bin/bash

echo "####################################################################"
echo "#                         Running setup.sh                         #"
echo "####################################################################"

cd "$(dirname "${BASH_SOURCE[0]}")"

composer install --no-interaction --prefer-dist

if [! -e "./.env" ]; then
    cp "./.env.example" "./.env"
    php artisan key:generate
    sed -i "s/APP_URL=http:\/\/localhost/APP_URL=http:\/\/localhost:8000/g" ./.env
fi

php artisan migrate --seed --force

npm install
gulp

php artisan serve
