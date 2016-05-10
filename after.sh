#!/bin/bash

# NOTE!
# This is a hacky fix, but its because vagrant runs this file as root
# and for some unknown reason to me, you can't just do `su vagrant`
# to change to that user. Instead we need to do the following to run
# all commands as vagrant: `su vagrant -c "COMMAND"`

echo "####################################################################"
echo "#                         Running After.sh                         #"
echo "####################################################################"

cd "/home/vagrant/homestead.app"

if [ ! -f "./.env" ]; then
    su vagrant -c "cp ./.env.example ./.env"
    su vagrant -c "php artisan key:generate"
    su vagrant -c "sed -i \"s/APP_URL=http:\/\/localhost/APP_URL=http:\/\/homestead.app/g\" ./.env"
fi

php artisan migrate --seed --force

su vagrant -c "npm install"
su vagrant -c "gulp"
