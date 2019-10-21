---
layout: blog
title: ubuntu下安装amqp扩展
categories: [PHP, 知识点]
description: some word here
keywords: keyword1, keyword2
cnblogsClass: \[Markdown\],\[随笔分类\]PHP
oschinaClass: \[Markdown\],PHP,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

## 环境
系统 ubuntu 16.04

php 7.1


## 下载扩展：
sudo apt-get -y install gcc make autoconf libc-dev pkg-config

sudo apt-get -y install libssl-dev

sudo apt-get -y install librabbitmq-dev

## 安装amqp:
sudo pecl install amqp

当出现如下提示时，只需按回车键即可

Set the path to librabbitmq install prefix [autodetect] :

添加 extension=amqp.so

sudo bash -c "echo extension=amqp.so > /etc/php/7.1/mods-avaliable/amqp.ini"

复制到conf.d,做软链：

sudo ln -s /etc/php/7.1/mods-available/amqp.ini /etc/php/7.1/fpm/conf.d/20-amqp.ini

sudo ln -s /etc/php/7.1/mods-available/amqp.ini /etc/php/7.1/cli/conf.d/20-amqp.ini

重启php-fpm:

sudo /etc/init.d/php7.1-fpm restart

## 验证
查看扩展fpm
php --ri amqp  

php -m |grep  amqp



