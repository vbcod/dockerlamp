FROM php:7.3-fpm-alpine
#Is not neccessary for mounting
#RUN mkdir /home/dockerlamp
RUN apk update && apk upgrade
RUN docker-php-ext-install mysqli pdo pdo_mysql
