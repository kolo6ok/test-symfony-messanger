FROM php:8.3-fpm as php_8_3-sqlite-dev

ARG user
ARG uid

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    zip \
    jpegoptim optipng pngquant gifsicle \
    unzip \
    git \
    libssl-dev \
    curl \
    libpq-dev \
    libonig-dev \
    libicu-dev \
    sqlite3 \
    libzip-dev

RUN apt clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure intl  \
    && docker-php-ext-install mbstring zip exif pcntl bcmath gd intl

RUN docker-php-source extract \
    && pecl install xdebug redis \
    && docker-php-ext-enable xdebug redis \
    && ln -s /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini /root/xdebug.ini \
    && docker-php-source delete

ADD ./docker/php/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
#
#ENV XDG_CONFIG_HOME "/usr/local/nvm"
#ENV NVM_DIR "/usr/local/nvm"
#
RUN useradd -G www-data,root -u $uid -m -d /home/$user -s /bin/bash $user
RUN mkdir -p /home/$user/.composer \
    && chown -R $user:$user /home/$user /var/www

USER $user

#RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.7/install.sh | bash
#RUN . "$NVM_DIR/nvm.sh" \
#    && . "$NVM_DIR/bash_completion" \
#    && nvm install --lts

WORKDIR /var/www

EXPOSE 9000
CMD ["php-fpm"]
