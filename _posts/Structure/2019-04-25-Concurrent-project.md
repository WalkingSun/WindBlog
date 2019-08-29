---
layout: blog
title: 大型项目架构相关概念及设计【draft】
categories: 并发, 连接池]
description: 记录大型项目所涉及到相关概念及处理措施
keywords: 并发
cnblogsClass: \[Markdown\],\[随笔分类\]架构
oschinaClass: \[Markdown\],PHP,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

- 缓存角度：提升系统访问速度
- 降级处理：拒绝服务、排队
- 限流：并发访问、限制 预估容量 超时 压垮 限流
- 代码 限流、服务器配置限制、数据库连接池、nginx配置（limit_conn模块）
- 网络连接数、CPU、内存负载、限流

- mysql连接池
数据库连接池是程序启动时建立足够的数据库连接，并将这些连接组成一个连接池，由程序动态的对池中的连接进行申请，使用，释放。

- 为什么建立连接池
与数据库服务器建立连接，TCP三次握手，本身很耗时，程序运行内存资源，程序结束，回收资源，4次挥手。

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/Screenshot_20190424-221704.jpg)

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/Screenshot_20190424-221824.jpg)



