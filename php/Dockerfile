ARG PHP_VERSION=8.3.0-fpm-bullseye
# 7.4.0-fpm-buster
FROM php:${PHP_VERSION}

ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update && \
    apt-get -y install \
        gnupg2 && \
    apt-key update && \
    apt-get update && \
    apt-get -y install \
            g++ \
            git \
            curl \
            imagemagick \
            ldap-utils \
            libcurl3-dev \
            libicu-dev \
            libfreetype6-dev \
            libjpeg-dev \
            libjpeg62-turbo-dev \
            libonig-dev \
            libmagickwand-dev \
            libpq-dev \
            libpng-dev \
            libxml2-dev \
            libzip-dev \
            zlib1g-dev \
            default-mysql-client \
            openssh-client \
            nano \
            unzip \
            libcurl4-openssl-dev \
            libssl-dev \
            supervisor \
        --no-install-recommends && \
        apt-get clean && \
        rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*


# Install LDAP extension for PHP
RUN apt-get update && \
    apt-get install libldap2-dev -y && \
    docker-php-ext-configure ldap --with-libdir=/lib/x86_64-linux-gnu/ && \
    docker-php-ext-install ldap

# Install MemCached extension for PHP
RUN apt-get install -y \
           memcached \
           libmemcached-dev \
   && git clone https://github.com/php-memcached-dev/php-memcached /usr/local/include/php/ext/memcached \
   && docker-php-ext-configure /usr/local/include/php/ext/memcached --disable-memcached-sasl \
   && docker-php-ext-install /usr/local/include/php/ext/memcached \
   && service memcached start


# Install PHP extensions required for Yii 2.0 Framework
ARG X_LEGACY_GD_LIB=0
RUN if [ $X_LEGACY_GD_LIB = 1 ]; then \
        docker-php-ext-configure gd \
                --with-freetype-dir=/usr/include/ \
                --with-png-dir=/usr/include/ \
                --with-jpeg-dir=/usr/include/; \
    else \
        docker-php-ext-configure gd \
                --with-freetype=/usr/include/ \
                --with-jpeg=/usr/include/; \
    fi && \
    docker-php-ext-configure bcmath && \
    docker-php-ext-install \
        soap \
        zip \
        curl \
        bcmath \
        exif \
        gd \
        iconv \
        intl \
        mbstring \
        opcache \
        pdo_mysql \
        pdo_pgsql \
        mysqli \
        pdo

RUN apt install libmcrypt-dev -y \
    && pecl install mcrypt \
    && docker-php-ext-enable mcrypt
    
# Install PECL extensions
RUN printf "\n" | pecl install \
    imagick \
    xdebug && \
    docker-php-ext-enable imagick

RUN docker-php-ext-install sockets

# Environment settings
ENV COMPOSER_ALLOW_SUPERUSER=1 \
    PHP_USER_ID=33 \
    PHP_MEMORY_LIMIT=1G \
    PHP_UPLOAD_MAX_FILESIZE=512M \
    PHP_POST_MAX_SIZE=512M \
    XDEBUG_PORT=9229 \
    PHP_ENABLE_XDEBUG=0 \
    TERM=linux \
    VERSION_PRESTISSIMO_PLUGIN=^0.3.10

# copy image configuration files
COPY image-files/ /

RUN chmod 755 \
    /usr/local/bin/docker-php-entrypoint

# # Install Yii framework bash autocompletion
RUN curl -L https://raw.githubusercontent.com/yiisoft/yii2/master/contrib/completion/bash/yii \
         -o /etc/bash_completion.d/yii

RUN mkdir -p /var/www/includes

RUN mkdir -p /var/www/html/tarsius

RUN echo "include_path = \".:/var/www/includes\"" >> /usr/local/etc/php/conf.d/docker-php-ext-yii.ini

# # Append Yii framework to php include_path
RUN echo "include_path = \".:/var/www/html/vendor:/var/www/html/vendor/bin\"" >> /usr/local/etc/php/conf.d/docker-php-ext-yii.ini

# include vendor/bin in PATH
ENV PATH="/var/www/html/vendor/bin:${PATH}"

RUN chown www-data:www-data -R /var/www/html

WORKDIR /var/www/html
