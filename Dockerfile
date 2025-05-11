FROM php:8.4-apache
LABEL maintainer="hariskhurshid@mcpinsight.com"

# Install necessary dependencies
RUN apt-get update \
    && apt-get install -y libpq-dev libpng-dev curl nano unzip zip git jq supervisor \
    && apt-get -y install build-essential autoconf libcurl4-openssl-dev --no-install-recommends

# Install the PHP extension installer and required extensions
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod uga+x /usr/local/bin/install-php-extensions && sync \
    && install-php-extensions zip gd intl \
    && curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php \
    && php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && a2enmod headers rewrite

# Set environment variables
ENV COMPOSER_HOME=/.composer COMPOSER_ALLOW_SUPERUSER=1 APACHE_DOCUMENT_ROOT=/var/www/portal

# Fix vHosts configuration
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}/public!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
    && mkdir -p ${APACHE_DOCUMENT_ROOT} /.composer && chown -R www-data:www-data ${APACHE_DOCUMENT_ROOT}

# Set working directory
WORKDIR ${APACHE_DOCUMENT_ROOT}

# Copy application files into container, ensuring kint_helper.php is copied
COPY --chown=www-data:www-data . ${APACHE_DOCUMENT_ROOT}

# Install composer dependencies
RUN composer install --no-autoloader --no-scripts --working-dir=${APACHE_DOCUMENT_ROOT}

# Dump the autoload files
RUN composer dump-autoload --optimize --working-dir=${APACHE_DOCUMENT_ROOT}

# Set permissions
RUN chown -R www-data:www-data ${APACHE_DOCUMENT_ROOT}
RUN chmod -R 777 ${APACHE_DOCUMENT_ROOT}/public
RUN chmod -R 777 ${APACHE_DOCUMENT_ROOT}/writable

# Move environment file to correct location
RUN mv ${APACHE_DOCUMENT_ROOT}/.env.production ${APACHE_DOCUMENT_ROOT}/.env


