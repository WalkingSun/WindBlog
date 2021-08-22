---
layout: blog
title: php7.1-fpm dockerfile
categories: [服务器,docker]
description: 记录docker遇到的坑
keywords: IM
cnblogsClass: \[Markdown\],\[随笔分类\]遇到问题,\[随笔分类\]服务器
oschinaClass: \[Markdown\],服务器,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

# php7.1-fpm dockerfile
```
FROM php:7.1-fpm

#  设置时区
ENV TZ=Asia/Shanghai
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# 更新为国内镜像
RUN mv /etc/apt/sources.list /etc/apt/sources.list.bak \
    && echo 'deb http://mirrors.ustc.edu.cn/debian stable main contrib non-free' > /etc/apt/sources.list \
    && echo 'deb-src http://mirrors.ustc.edu.cn/debian stable main contrib non-free' >> /etc/apt/sources.list \
    && echo 'deb http://mirrors.ustc.edu.cn/debian stable-proposed-updates main contrib non-free' >> /etc/apt/sources.list \
    && echo 'deb-src http://mirrors.ustc.edu.cn/debian stable-proposed-updates main contrib non-free' >> /etc/apt/sources.list \
    && echo 'deb http://ftp.cn.debian.org/debian/ jessie main non-free' >> /etc/apt/sources.list

#  更新安装依赖包和PHP核心拓展
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libbz2-dev \
        libcurl4-gnutls-dev \
        && docker-php-ext-install mysqli pdo pdo_mysql opcache json calendar bcmath  zip bz2 mbstring curl \
        && rm -r /var/lib/apt/lists/*

# GD 扩展
RUN apt-get install -y --no-install-recommends libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
    && rm -r /var/lib/apt/lists/* \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

# Redis、Xdebug扩展
RUN pecl install redis-5.1.1 \
    && pecl install xdebug-2.8.1 \
    && docker-php-ext-enable redis xdebug

# amqp 扩展
RUN apt-get update && apt-get install -y librabbitmq-dev libssl-dev \
    && pecl install amqp \
    && docker-php-ext-enable amqp


## imagick 扩展
#RUN export CFLAGS="$PHP_CFLAGS" CPPFLAGS="$PHP_CPPFLAGS" LDFLAGS="$PHP_LDFLAGS" \
#    && apt-get install -y --no-install-recommends libmagickwand-dev \
#    && rm -r /var/lib/apt/lists/* \
#    && pecl install imagick-3.4.4 \
#    && docker-php-ext-enable imagick

# mcrypt 扩展
#RUN apt-get install -y --no-install-recommends libmcrypt-dev \
#    && rm -r /var/lib/apt/lists/* \
#    && pecl install mcrypt-1.0.2 \
#    && docker-php-ext-enable mcrypt

# Memcached 扩展
#RUN apt-get install -y --no-install-recommends libmemcached-dev zlib1g-dev \
#    && rm -r /var/lib/apt/lists/* \
#    && pecl install memcached-3.1.3 \
#    && docker-php-ext-enable memcached

# opcache 扩展
RUN docker-php-ext-configure opcache --enable-opcache && docker-php-ext-install opcache

#  安装第三方拓展，这里是 Phalcon 拓展
#RUN cd /home \
#    && tar -zxvf cphalcon.tar.gz \
#    && mv cphalcon-* phalcon \
#    && cd phalcon/build \
#    && ./install \
#    && echo "extension=phalcon.so" > /usr/local/etc/php/conf.d/phalcon.ini

#  安装 Composer
ENV COMPOSER_HOME /root/composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ENV PATH $COMPOSER_HOME/vendor/bin:$PATH


#WORKDIR /data
##  Write Permission
#RUN usermod -u 1000 www-data

LABEL Author="walkingsun"
LABEL Version="2020.06"
LABEL Description="PHP 7.1 开发环境镜像. "
```
