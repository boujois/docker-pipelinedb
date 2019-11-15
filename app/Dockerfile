FROM php:7.2-apache

MAINTAINER Daniel Bougourd

RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql
COPY src/ /var/www/html/
RUN a2enmod rewrite
