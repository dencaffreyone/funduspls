FROM composer:1.6.3 as composer

FROM node:8.10.0 as node

FROM php:7.2.19-fpm

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY --from=node /usr/local/bin/node /usr/local/bin/node
COPY --from=node /usr/local/lib/node_modules /usr/local/lib/node_modules
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm
RUN npm install npm@6.0.0 -g
RUN npm install yarn@1.17.3 -g

RUN apt-get update && apt-get install -y vim && apt-get install -y git libzip-dev zlib1g-dev

COPY www.conf /usr/local/etc/php-fpm.d/www.conf

RUN usermod -u 1000 www-data \
 && groupmod -g 1000 www-data \
 && chgrp -R staff /usr/local/etc/php-fpm.d/www.conf

RUN docker-php-ext-install pdo pdo_mysql zip

EXPOSE 9000