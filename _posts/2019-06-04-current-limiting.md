---
layout: blog
title: 限流方案分析【draft】
categories: [cate1, cate2]
description: 应对突发流量的限流方案处理
keywords: 限流,redis
cnblogsClass: \[Markdown\],\[随笔分类\]架构
oschinaClass: \[Markdown\]
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

<!--
title内容带draft标识草稿

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

# 背景
应对突发流量或者是大流量涌入，为了保护系统不至于崩溃，需要做限流的处理。本文对限流处理做些分析，模拟语言PHP，数据库redis。

# 计数器方案
对1秒内的连接做限制，超过限制，拒绝服务。



# 令牌桶算法


# 漏桶算法