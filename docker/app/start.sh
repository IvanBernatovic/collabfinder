#!/usr/bin/env bash

set -e

role=${CONTAINER_ROLE:-app}
env=${APP_ENV:-production}

exec php-fpm

# echo "Installing dependencies if needed..."
# composer install

# if [ "$env" != "local" ]; then
#   echo "Caching configuration..."
#   (cd /var/www && php artisan config:cache && php artisan route:cache && php artisan view:cache)
# fi

# if [ "$role" = "app" ]; then

#   exec php-fpm

# elif [ "$role" = "queue" ]; then

#   php /var/www/artisan queue:work

# elif [ "$role" = "scheduler" ]; then

#   while [ true ]; do
#     php /var/www/artisan schedule:run --verbose --no-interaction &
#     sleep 60
#   done

# else
#   echo "Could not match the container role \"$role\""
#   exit 1
# fi
