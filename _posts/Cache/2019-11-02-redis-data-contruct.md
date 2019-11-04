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
在我们平时开发过程中，会有一些 bool 型数据需要存取，比如用户一年的签到记录，签了是 1，没签是 0，要记录 365 天。如果使用普通的 key/value，每个用户要记录 365 个，当用户上亿的时候，需要的存储空间是惊人的。
为了解决这个问题，Redis 提供了位图数据结构，这样每天的签到记录只占据一个位，365 天就是 365 个位，46 个字节 (一个稍长一点的字符串) 就可以完全容纳下，这就大大节约了存储空间。

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/1566527501259-5ba9e6b2-e3dd-4c17-9c23-206c28703b6c.gif)

位图不是特殊的数据结构，它的内容其实就是普通的字符串，也就是 byte 数组。我们可以使用普通的 get/set 直接获取和设置整个位图的内容，也可以使用位图操作 getbit/setbit 等将 byte 数组看成「位数组」来处理。

当我们要统计月活的时候，因为需要去重，需要使用 set 来记录所有活跃用户的 id，这非常浪费内存。这时就可以考虑使用位图来标记用户的活跃状态。每个用户会都在这个位图的一个确定位置上，0 表示不活跃，1 表示活跃。然后到月底
遍历一次位图就可以得到月度活跃用户数。不过这个方法也是有条件的，那就是 userid 是整数连续的，并且活跃占比较高，否则可能得不偿失。

### 基本使用
Redis 的位数组是自动扩展，如果设置了某个偏移位置超出了现有的内容范围，就会自动将位数组进行零扩充。

来了解几个命令：
- setbit  key offset value 对 key 所储存的字符串值，设置或清除指定偏移量上的位(bit)。
- getbit  key offset   对 key 所储存的字符串值，获取指定偏移量上的位(bit)。
- BITCOUNT key [start] [end] 计算给定字符串中，被设置为 1 的比特位的数量。
```
127.0.0.1:6379> setbit s 1 1
(integer) 0
127.0.0.1:6379> setbit s 2 1
(integer) 0
127.0.0.1:6379> setbit s 4 1
(integer) 0
127.0.0.1:6379> setbit s 9 1
(integer) 0
127.0.0.1:6379> setbit s 10 1
(integer) 0
127.0.0.1:6379> setbit s 13 1
(integer) 0
127.0.0.1:6379> setbit s 15 1
(integer) 0
127.0.0.1:6379> get s
"he"   #01101000 01100101  
127.0.0.1:6379> getbit s 1
(integer) 1
127.0.0.1:6379> BITCOUNT s
(integer) 7

```