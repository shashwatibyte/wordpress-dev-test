FROM wordpress:latest

COPY . /var/www/html/wp-content/themes/wordpress-dev-test

ENTRYPOINT ["/bin/bash", "-c", "rm -f /etc/apache2/mods-enabled/mpm_event.* /etc/apache2/mods-enabled/mpm_worker.* && a2enmod mpm_prefork && exec docker-entrypoint.sh apache2-foreground"]
