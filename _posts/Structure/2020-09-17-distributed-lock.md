layout: blog
title: 分布式锁【draft】
categories: 分布式
description: 分布式锁记录些实现逻辑及细节处理
keywords: 分布式
cnblogsClass: \[Markdown\],\[随笔分类\]架构
oschinaClass: \[Markdown]
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]

# 分布式锁

实现原则：

- 互斥性
- 避免出现死锁；
- 容错性；
- 加锁解锁同一客户端（解铃还需系铃人）