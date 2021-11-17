## DESCRIPTION
- http://dockerlamp/ и http://dockerlamp/index.php
- Динамический контент из index.php

- http://dockerlamp/info.php
- Php info

- http://dockerlamp/index.html
- Статический контент

- http://dockerlamp/create-table.php
- Создает таблицу tbl_dockerlamp в базе данных dockerlamp в контейнере dockerlamp--mysql (бд должна быть создана вручную заранее)

- Проект можно тушить и включать. Все генерируемые/используемые ими файлы/данные хранятся на хостовой машине и монтируются в container в момент его запуска.

- Файлы сайта доступны на хостовой машине: ~/dockerlamp/webhosting/public_html
- Файлы сайта доступны в контейнерах httpd, php: /home/dockerlamp/public_html
- Имитация home для cPanel хостинг-аккаунта на хостовой машине: ~/dockerlamp/webhosting
- Имитация home для cPanel хостинг-аккаунта в контейнерах httpd, php: /home/dockerlamp

- Весь docker-based проект лежит на хостовой машине: ~/dockerlamp
- Файлы-базы-данных: ~/dockerlamp/container-data/mysql/use-as-var-lib-mysql
- Конфиг web-сервера лежит на хостовой, монтируется в контейнер

### Containers & Images имеют одинаковое название
- dockerlamp--httpd
- dockerlamp--php
- dockerlamp--mysql

### Docker Network, через которую связываются containers
- dockerlamp

## REQUIREMENTS
- Установленный, работающий docker на хостовой машине

## INSTALL
### Положить папку проекта
Папку, в которой лежит этот файл положить по пути: ~/dockerlamp

### Резолвить dockerlamp в 127.0.0.1
- sudo bash
- echo "127.0.0.1 dockerlamp" >> /etc/hosts
- Ctrl+D (exit sudo bash)

### Создать image с веб-сервером
docker build ~/dockerlamp/image-build-context/httpd -t dockerlamp--httpd

### Создать image с php
docker build ~/dockerlamp/image-build-context/php -t dockerlamp--php

### Создать image с mysql
docker build ~/dockerlamp/image-build-context/mysql -t dockerlamp--mysql

### Создать network для коммуникации containers, которые будут запущены на базе только что созданных images
docker network create dockerlamp

### Запустить container с mysql
docker run \
-dit \
--restart=always \
-p 3306:3306 \
-v ~/container-data/mysql/use-as-var-lib-mysql:/var/lib/mysql \
--network dockerlamp \
--name dockerlamp--mysql \
dockerlamp--mysql

### Запустить container с php
docker run \
-dit \
-v ~/dockerlamp/webhosting:/home/dockerlamp \
--network dockerlamp \
--name dockerlamp--php \
dockerlamp--php

### Запустить container с веб-сервером
docker run \
-dit \
-p 80:80 \
-v ~/dockerlamp/container-data/httpd/httpd.conf:/usr/local/apache2/conf/httpd.conf \
-v ~/dockerlamp/webhosting:/home/dockerlamp \
--network dockerlamp \
--name dockerlamp--httpd \
dockerlamp--httpd

## UNINSTALL
docker container stop dockerlamp--mysql dockerlamp--php dockerlamp--httpd
docker container rm dockerlamp--mysql dockerlamp--php dockerlamp--httpd
docker image rm dockerlamp--mysql dockerlamp--php dockerlamp--httpd
docker network rm dockerlamp

Очистить ~/dockerlamp/public_html
Очистить ~/dockerlamp/container-data/mysql/use-as-var-lib-mysql
Удалить ~/dockerlamp

## USAGE
### Создать базу данных
- mysql -uroot -p12345678 -h127.0.0.1 (или указать ip контейнера) ИЛИ
-- docker exec -ti dockerlamp--mysql /bin/bash
-- mysql -uroot -p12345678

- CREATE DATABASE dockerlamp;

### Узнать ip-адрес контейнера с БД
docker inspect dockerlamp--mysql
-> NetworkSettings
-> Networks
-> dockerlamp
-> IPAddress

### Посмотреть список существующий containers
docker container ls --all

### Посмотреть список существующий images
docker image ls

### Посмотреть список существующий network
docker network ls