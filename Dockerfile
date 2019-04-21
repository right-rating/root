#Pull base image
   FROM ubuntu
   #Install Apache
   RUN apt-get update -y && apt-get install apache2 apache2-utils -y

#Define default port
   EXPOSE 80

   COPY . /var/www/html/

   ENTRYPOINT [ "/usr/sbin/apache2ctl" ]

#Define default command
  #CMD sed -i "s/80/$PORT/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf && docker-php-entrypoint apache2-foreground

  CMD [ "-D", "FOREGROUND" ]
