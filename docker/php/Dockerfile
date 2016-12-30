FROM debian:jessie

MAINTAINER Ilan B <ilan.prims@gmail.com>

RUN apt-get update && apt-get install -y \
  git \
  curl \
  wget \
  php5-fpm \
  php5-curl \
  php5-json \
  php5-mcrypt \
  php5-memcached

RUN sed -e "s,listen = /var/run/php5-fpm.sock, listen = 0.0.0.0:9000,g" -i /etc/php5/fpm/pool.d/www.conf

RUN wget https://getcomposer.org/composer.phar && mv composer.phar /usr/local/bin/composer
RUN chmod +x /usr/local/bin/composer

CMD ["php5-fpm", "-F"]

WORKDIR /var/www/cap

EXPOSE 9000
