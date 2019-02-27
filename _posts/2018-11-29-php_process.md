---
layout: blog
title: PHP安装posix、pctl扩展
categories: [PHP, 遇到问题]
description:
keywords: posix, 遇到问题
cnblogsClass: \[Markdown\],\[随笔分类\]遇到问题
oschinaClass: \[Markdown\],PHP,服务器,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

# 安装问题

```
PHP Fatal error: Uncaught Error: Call to undefined function tsingsun\swoole\server\posix_kill() in /data/app/im/vendor/tsingsun/yii2-swoole/src/server/Server.php:248
```
查了下，php的扩展posix没开，php版本php7.1,环境CentOS7,使用如下命令解决：
```
yum install php71w-process  #如果版本是5.6,php56w-process
```

碰到点问题：CentOS7默认安装的都是php5.6的扩展，
```
yum install php-process
```
一直报错，坑一笔，用上面的方法指定版本轻松安装。

# PECL 扩展管理工具
PECL 的全称是 The PHP Extension Community Library ，是一个开放的并通过 PEAR(PHP Extension and Application Repository，PHP 扩展和应用仓库)打包格式来打包安装的 PHP扩展库仓库。通过 PEAR 的 Package Manager 的安装管理方式，可以对 PECL 模块进行下载和安装。
```
curl -o go-pear.php http://pear.php.net/go-pear.phar
chmod +x go-pear.php
/usr/local/php-7.1.13/bin/php go-pear.php
```
如安装swoole：
```
pecl install swoole
```
升级扩展
```
pecl upgrade swoole
```
