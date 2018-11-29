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

<!--
cnblogsClass: 【你的博客园的分类，以逗号分隔，注意\[Markdown\]必须项】
oschinaClass: 【你的开源中国的分类】
csdnClass: 【你的CSDN分类】
...

注：由于'['、']'是jekyll的关键字，故在分类中请加上'\'；

可以在网站下添加操作看到你的博客分类，案列是自己的分类，需要自行修改。
添加这些分类的目的，是可以自动同步到对应的博客网站，新建博客以此模版文件复制创建markdown文件，如果你不需要，请跳过此步。


图片地址存放参考：
本地存放路径/WindBlog/gh-pages/images/blog/b.png
git上：
![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/b.png)

-->

碰到个问题
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

