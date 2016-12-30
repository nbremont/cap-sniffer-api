FROM debian:jessie

MAINTAINER Ilan B <ilan.prims@gmail.com>

RUN apt-get update && apt-get install -y \
  git \
  nginx

ADD cap.conf /etc/nginx/sites-available/cap.conf
RUN ln -s /etc/nginx/sites-available/cap.conf /etc/nginx/sites-enabled/cap.conf

CMD ["nginx", "-g", "daemon off;"]

EXPOSE 80
