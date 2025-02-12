FROM php:8.1-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid
ARG app_env=production

# Install system dependencies
RUN apt-get update && apt-get install -y \
  git \
  curl \
  libpng-dev \
  libonig-dev \
  libxml2-dev \
  zip \
  unzip \
  libzip-dev

# Clear cache`
RUN apt-get clean && rm -rf /var/lib/apt/lists/*


RUN if [ ${app_env} = local ] ; then \
  pecl install xdebug \
  && docker-php-ext-enable xdebug \
  && echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
  && echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
  && echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
  && echo "xdebug.discover_client_host.=0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
  && echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
  && echo "xdebug.mode=profile,debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
  && echo "xdebug.output_dir=/tmp/snapshots" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
  && echo "xdebug.max_nesting_level=9999" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
  && echo "xdebug.start_with_request=trigger" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
  && echo 'alias xoff="mv /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini.off && kill -USR2 1"' >> ~/.bashrc \
  && echo 'alias xon="mv /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini.off /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && kill -USR2 1"' >> ~/.bashrc \
  ;fi

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd soap zip

RUN docker-php-ext-configure opcache --enable-opcache \
  && docker-php-ext-install opcache

RUN pecl install -o -f redis \
  &&  rm -rf /tmp/pear \
  &&  docker-php-ext-enable redis

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user && \
  usermod -p "*" $user -s /bin/bash
RUN mkdir -p /home/$user/.composer && \
  chown -R $user:$user /home/$user

COPY docker/app/start.sh /usr/local/bin/start
RUN chmod u+x /usr/local/bin/start

# Set working direc2tory
WORKDIR /var/www

USER $user

CMD ["bash", "/usr/local/bin/start"]