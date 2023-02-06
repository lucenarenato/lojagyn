# WordPress Dockerfile: Create container from official WordPress image, basic customizations.
# docker build -t wordpress_local:wp_custom_1.0 .

FROM wordpress:5.6.2-php7.4-fpm-alpine

# APT Update/Upgrade, then install packages we need
RUN apk add --update --no-cache \
    curl \
    ncdu \
    openssl \
    mc \
    vim \
    wget 
    # \
    # mariadb-client

# ioncube loader
RUN curl -fSL 'https://downloads.ioncube.com/loader_downloads/ioncube_loaders_lin_x86-64.tar.gz' -o ioncube.tar.gz \
    && mkdir -p ioncube \
    && tar -xf ioncube.tar.gz -C ioncube --strip-components=1 \
    && rm ioncube.tar.gz \
    # && cp ioncube/ioncube_loader_lin_7.4.so /opt/sp/php7.4/lib/php/extensions/no-debug-non-zts-20190902/ioncube_loader_lin_7.4.so \
    && cp ioncube/ioncube_loader_lin_7.4.so /usr/local/lib/php/extensions/no-debug-non-zts-20190902/ioncube_loader_lin_7.4.so \
    # && mv ioncube/ioncube_loader_lin_7.3.so /var/www/ioncube_loader_lin_7.3.so \
    && rm -r ioncube \
    # echo "zend_extension=/opt/sp/php7.4/lib/php/extensions/no-debug-non-zts-20190902/ioncube_loader_lin_7.4.so" > /etc/php7.4-sp/conf.d/20ioncube.ini
    && echo "zend_extension=/usr/local/lib/php/extensions/no-debug-non-zts-20190902/ioncube_loader_lin_7.4.so" > /usr/local/etc/php/conf.d/00_docker-php-ext-ioncube_loader_lin_7.4.ini
  

# composer
RUN curl -S https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer self-update

# node
# RUN curl -o- https://raw.githubusercontent.com/creationix/nvm/v0.33.11/install.sh | bash \
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.1/install.sh | bash \ 
    && export NVM_DIR="$HOME/.nvm" \
    && . $NVM_DIR/nvm.sh \
    && nvm install v12.4.0 \
    && nvm use v12.4.0 \
    && nvm alias default v12.4.0 
    # && npm install -g npm

# Replace php.ini
# COPY php.ini /usr/local/etc/php
# COPY uploads.ini /usr/local/etc/php/conf.d 

# Install WP-CLI
# RUN wget https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && \
#     php wp-cli.phar --info&& \
#     chmod +x wp-cli.phar && \
#     mv wp-cli.phar /usr/local/bin/wp && \
#     # Remove old php.ini files (wihtout creating new image)
#     rm /usr/local/etc/php/php.ini-development && \
#     rm /usr/local/etc/php/php.ini-production