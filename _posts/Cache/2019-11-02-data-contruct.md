---
layout: blog
title: redis数据结构及场景【draft】
categories: [redis, 事务]
description: 了解redis的数据结构，应用场景
keywords: redis, 事务, 乐观锁
cnblogsClass: \[Markdown\],\[随笔分类\]服务器,\[随笔分类\]数据库
oschinaClass: \[Markdown\],数据库,服务器,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

# 数据结构

string、hash、list、set、zset、bitmap、HyperLogLog、stream


常用的前5种类型不做细究，来看看后面一个的结构及用法。

## bitmap