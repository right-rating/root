#Pull base image
   FROM php:apache
   #Set up php
   RUN docker-php-ext-install pdo pdo_mysql
   #RUN apt-get update -y && apt-get install apache2 apache2-utils -y
   RUN docker-php-ext-install pdo_mysql
   SHELL ["/bin/bash", "-c"]
   RUN ln -s ../mods-available/{expires,headers,rewrite}.load /etc/apache2/mods-enabled/
   RUN sed -e '/<Directory \/var\/www\/>/,/<\/Directory>/s/AllowOverride None/AllowOverride All/' -i /etc/apache2/apache2.conf
   #COPY php.ini /usr/local/etc/php/

#Define default port
   EXPOSE 80

   COPY ./right_review_codebase /var/www/html/
   #RUN rm /var/www/html/index.html
   ENTRYPOINT [ "/usr/sbin/apache2ctl" ]

#Define default command
  #CMD sed -i "s/80/$PORT/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf && docker-php-entrypoint apache2-foreground

  CMD [ "-D", "FOREGROUND" ]
