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

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/20190610loutong.png)

假设令牌发放速度是每秒5个，容量是20，下一个请求过去4秒，则现在拥有20个令牌，相当与一秒可以处理20个突发请求的能力。

令牌桶算法对突发流量可以很好的支持。

笔者使用redis悲观锁模拟了下：[传送门](https://github.com/WalkingSun/Jump/blob/master/controllers/CurrentlimitController.php)

限流日志片段如下：
```html
2019-06-10 14:15:34：34156014733415798_1560147334.5618_1560147334.6274_3

2019-06-10 14:15:34：34156014733415798 访问成功

2019-06-10 14:15:34：34156014733366588_1560147334.6274_1560147334.7413_2

2019-06-10 14:15:34：34156014733366588 访问成功

2019-06-10 14:15:34：961560147334752681_1560147334.7413_1560147334.8384_1

2019-06-10 14:15:34：961560147334752681 访问成功

2019-06-10 14:15:35：281560147334556592_1560147334.8384_1560147334.9778_0

2019-06-10 14:15:35：281560147334556592 访问失败

2019-06-10 14:15:35：1001560147334509357_1560147334.9778_1560147335.0564_0

2019-06-10 14:15:35：1001560147334509357 访问失败
```

基于上面算法来计算，如果直接用php会有很大的问题，redis的多个请求高并发下面临很多问题，无法保持原子性。故可使用redis+lua实现多个redis请求原子性操作。

php+redis+lua 实现令牌桶：
https://segmentfault.com/a/1190000018761106

或者 php另起一个进程或者线程来生成令牌token放入队列中，过来请求出队一个，token拿到就继续业务处理，反之拒绝此请求。

# 漏桶算法

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/20190610loutonga.png)



> 漏统 VS 令牌桶

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/20190610loutong2lingpaitong.png)
