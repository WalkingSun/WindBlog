---
layout: blog
title: redis集群【draft】
categories: [redis, 事务]
description: 了解redis集群的设置方案
keywords: redis, 集群
cnblogsClass: \[Markdown\],\[随笔分类\]服务器,\[随笔分类\]数据库
oschinaClass: \[Markdown\],数据库,服务器,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

# 集群

## Cluster
Redis官方提供的的集群方案，它是去中心化的，redis-cluster采用的是hash slot，[0,16383]slot,把多个redis实例整合在一起，形成一个集群，每个节点存储一部分数据。
每个节点都保存其它节点的状态和它负责的槽，当需要在 Redis 集群中放置一个 key-value 时，redis 先对 key 使用 crc16 算法算出一个结果，然后把结果对 16384 求余数，这样每个 key 都会对应一个编号在 0-16383 之间的哈希槽，
redis 会根据节点数量大致均等的将哈希槽映射到不同的节点

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/QQ20191103-213557@2x.png)

### 跳转
当客户端向一个错误的节点发出了指令，该节点发现指令的key所在的槽位并不归自己管理，这是会向客户端发送一个特殊的跳转命令携带目标操作的节点地址，告诉客户端去连这个节点去获取数据。
```
GEt x
-MOVED 3999 127.0.0.1:6381
```
MOVED指令的第一个参数3000是key对应的槽位编号，后面是目标节点地址。MOVED指令前面又一个减号，表示该指令是一个错误信息。
客户端收到MOVED指令后，要立即纠正本地的槽位映射表。后续所有key将使用新的槽位映射表。

### 迁移
Redis CLuster提供了工具redis-trib可以让运维人员手动调整槽位的分配情况。

### 容错
Redis Cluster可以为每个主节点设置若干个从节点，单主节点故障时，集群会自动将其中某个从节点提升为主节点。
如果某个主节点没有从节点，那么当他发生故障时，集群将完全处于不可用状态。不过redis提供一个参数cluster-require-full-coverage可以允许部分节点故障，其他节点继续提供对外访问。

### 网络抖动
真实世界的机房经常会出现各种各样的小问题。比如网络抖动就分厂常见现象，突然之间部分连接变得不可访问，然后很快又自动恢复正常。

Redis Cluster提供了一种选项cluster-node-timeout，表示这个节点持续timeout时间失联时，才可以认定该节点出现故障，需要进行主从切换。如果没有这个选项，网络抖动会导致主从频繁切换（数据的重新复制）。

cluster-slave-validity-factor选项作为倍乘系数来放大这个超时时间来宽松容错的紧急程度。如果这个系数为零，那么主从切换不会抗拒网络抖动的。如果这个系数大于1，它就成了主动切换的松弛系数。

### 投票
当一个节点发现某个节点ping-pong不通，就会向其它节点广播该节点可能发生的错误，所有节点对该节点进行检测，超过半数，则认为该节点挂掉

### 集群不可用
- 集群中任意master挂掉，且没有slave。集群进入fail状态
- 集群超过半数以上的master挂掉，无论是否有slave都进入fail状态

### 集群变更感知
当服务器节点变更时，客户端应该即时得到通知以实时刷新自己的节点关系表。那客户端是如何得到通知的呢？这里要分 2 种情况：
- 目标节点挂掉了，客户端会抛出一个 ConnectionError，紧接着会随机挑一个节点来重试，这时被重试的节点会通过 moved error 告知目标槽位被分配到的新的节点地址。
- 运维手动修改了集群信息，将 master 切换到其它节点，并将旧的 master 移除集群。这时打在旧节点上的指令会收到一个 ClusterDown 的错误，告知当前节点所在集群不可用 (当前节点已经被孤立了，它不再属于之前的集群)。这时客户端就会关闭所有的连接，清空槽位映射关系表，然后向上层抛错。待下一条指令过来时，就会重新尝试初始化节点信息。

### 集群搭建


## hash一致性

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/20190612hash1.png)

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/20190612hash2.png)

通过程序去划分集群

## Codis
分布式集群存储方案