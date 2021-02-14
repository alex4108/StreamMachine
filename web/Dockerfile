FROM php:7.4.15-apache-buster

RUN apt-get -y update

# Install website
COPY ./src/ /var/www/html
COPY config.php /var/www/
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Start container
EXPOSE 80
ENTRYPOINT "/entrypoint.sh"
