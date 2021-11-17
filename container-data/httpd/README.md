## Файлы httpd.conf
### httpd.conf.orig
Получен так: docker run --rm httpd:2.4 cat /usr/local/apache2/conf/httpd.conf >> httpd.conf.orig

### httpd.conf
Получен так: cp httpd.conf.orig httpd.conf
Внесены изменения (см diff) в httpd.conf, необходимые для работы в связке с контейнером php.
