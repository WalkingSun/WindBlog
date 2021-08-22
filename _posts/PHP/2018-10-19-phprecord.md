---
layout: post
title: 原理分析记录
categories: [PHP]
description:
keywords: php
---
做下记录

# PHP版本分TS和NTS，有什么区别？怎么选择?

TS 线程安全，多线程下的数据访问资源共享，一个线程访问就会对其加锁，其他线程只能等待，防止其他线程造成数据修改。优点不会造成数据不一致或数据污染，缺点耗费时间和系统资源。

NTS 非线程安全，不提供数据保护，任何线程都可修改同一数据，造成数据错乱（脏数据），优点耗费时间短。

## 选择

　　通常win下 PHP + Apache 组合，以 ISAPI 的方式运行。

　　而linux下通常分为2种：

　　 Apache + PHP，PHP一般作为Apache 的模块进行运行；

　　 Nginx + PHP ，以 phpfast cgi的方式，即php-fpm的方式运行，该方式对高并发、高负载有良好的性能体现，因此很多网站采用该方式进行环境的搭建。

　　Nginx 较Apache 的配置要少很多，因此人为出错的概率要少一点，但也因此 Apache 的 稳定性要比Nginx 高。

## 总结：

以 ISAPI 方式运行就用 TS 线程安全版
以 FAST-CGI 或 PHP-FPM 方式运行就用NTS 非线程安全版
通常 Windows 下 Apache + PHP 选TS ，IIS（fast-cgi） + PHP 选TNS
通常Linux 下 Apache + PHP 选TS，Nginx + PHP 选TNS

个人理解 NTS 并发情况会较TS高很多，系统级的加锁完全可以使用程序级加锁代替，还有一部分大量的仅是读操作，效率高很多。


