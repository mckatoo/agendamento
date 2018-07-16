#!/bin/bash

echo umask 000 >> /etc/bash.bashrc && \
adduser mckatoo && \
adduser mckatoo sudo && \
apt update && \
apt install -y sudo nano unzip wget curl nginx && \
/etc/init.d/nginx start && \
apt install -y php7.2 php7.2-curl php7.2-common php7.2-cli php7.2-mysql php7.2-mbstring php7.2-fpm php7.2-xml php7.2-zip && \
echo cgi.fix_pathinfo=0 >> cd /etc/php/7.2/fpm/php.ini && \
/etc/init.d/php7.2-fpm start && \
apt install -y mysql-server mysql-client && \
/etc/init.d/mysql start && \
#mysql_secure_installation && \
apt install -y composer;

if [ ! -d "agendamento" ]
  then
    sudo -u mckatoo composer create-project --prefer-dist laravel/lumen agendamento;
  else
    cd agendamento && sudo -u mckatoo composer install;
fi

cp /var/www/html/laravel-nginx-config /etc/nginx/sites-available/default && \
#ln -s /etc/nginx/sites-available/laravel-nginx-config /etc/nginx/sites-enabled/ && \
/etc/init.d/nginx restart;
chmod 755 /var/www/html/agendamento/storage
