---
layout: post
title: MySQL事务原理【draft】
categories: [DB,MySQL]
description: 理解事务
keywords: 事务
cnblogsClass: \[Markdown\],\[随笔分类\]数据库
oschinaClass: \[Markdown\],数据库,日常记录
---

记录总结下事务，研究下原理

# 事务

事务四大特性ACID：原子性、一致性、隔离性、持久性。

原子性：事务的执行要么全部成功，要么全部失败；

一致性：事务查询前后数据一致；

隔离性：多个事务间相互隔离，互不影响；

持久性：事务对数据的影响是持久的，及时数据库宕机。

# 隔离级别
隔离级别四种：未提交读、提交读、可重复读、串行化。Mysql默认可重复读。

未提交读(Read Uncommitted)：允许脏读，也就是可能读取到其他会话中未提交事务修改的数据

提交读(Read Committed)：只能读取到已经提交的数据。Oracle等多数数据库默认都是该级别 (不重复读)

可重复读(Repeated Read)：可重复读。在同一个事务内的查询都是事务开始时刻一致的，InnoDB默认级别。在SQL标准中，该隔离级别消除了不可重复读，但是还存在幻象读

串行读(Serializable)：完全串行化的读，每次读都需要获得表级共享锁，读写相互都会阻塞


| 隔离级别 |	脏读（Dirty Read）|	不可重复读（NonRepeatable Read）|	幻读（Phantom Read）|
| ----    | ---- | ----|---|
| 未提交读（Read uncommitted）|	可能   |	可能   |	可能 |
| 已提交读（Read committed）  |	不可能 |	可能   |	可能 |
| 可重复读（Repeatable read）	|不可能	  | 不可能  | 可能 |
| 可串行化（Serializable ）	|不可能    |	不可能  | 不可能 |


> 不可重复读和幻读的区别

很多人容易搞混不可重复读和幻读，确实这两者有些相似。但**不可重复读重点在于update和delete，而幻读的重点在于insert**。

如果使用锁机制来实现这两种隔离级别，在可重复读中，该sql第一次读取到数据后，就将这些数据加锁，其它事务无法修改这些数据，就可以实现可重复读了。但这种方法却无法锁住insert的数据，所以当事务A先前读取了数据，
或者修改了全部数据，事务B还是可以insert数据提交，这时事务A就会发现莫名其妙多了一条之前没有的数据，这就是幻读，不能通过行锁来避免。需要Serializable隔离级别 ，读用读锁，写用写锁，读锁和写锁互斥，这么做
可以有效的避免幻读、不可重复读、脏读等问题，但会极大的降低数据库的并发能力。


```sql
mysql> select @@tx_isolation;
+-----------------+
| @@tx_isolation  |
+-----------------+
| REPEATABLE-READ |
+-----------------+
1 row in set, 1 warning (0.00 sec)
```
REPEATABLE READ 意味着：

同一个事务中多次执行同一个select,读取到的数据没有发生改变；

允许幻读，但不允许不可重复读和脏读，所以RR隔离级别要求解决不可重复读；


设置隔离级别：

```sql
mysql> set global transaction isolation level read committed; //系统级的隔离级别

mysql> set session transaction isolation level read committed; //会话级的隔离级别
```
# 事务工作流程

MVCC 多版本并发控制。数据库的事务型存储引擎基于提升并发性能的实现会使用MVCC。

通过在每行记录后面保存两个隐藏的列来实现的，创建版本号、删除版本号。

增：记录中的创建版本号=当前事务版本号

删：记录的删除版本号=当前事务版本号

改：原记录的删除版本号=当前事务版本号；新纪录的创建版本号=当前版本号；

查：查询记录创建版本号小于等于当前事务版本号（确保读取到事务开启前的数据或者当前事务改变的数据）且删除版本号为null或者删除版本号>当前事务版本号（确保在事务开启前未删除）的的快照  


优点： 保存这两个额外系统版本号，使大多数读操作都可以不用加锁。这样设计使得读数据操作很简单，性能很好。

缺点： 每行纪录都需要额外的存储空间，需要做更多的行检查工作，以及一些额外的维护工作。


通过MVCC版本控制，规避锁的开销（加锁过度会降低系统并发处理能力）

> 隔离级别结合MVCC，绝大多数读是快照读（读的历史），部分读（for update、lock in mod、update）属于当前读。


隔离级别中 提交读、可重复读 使用了MVCC。

## 提交读 MVVC应用
1.开启两个客户端实例,设置事务隔离级别为read committed，并各自开启事务。
```sql
  set session transaction isolation level read committed;
  set autocommit = 0;
  begin；

```  

2.客户端1做更新操作：
```sql
mysql> update test set d = '测试' where id =1;
Query OK, 0 rows affected (0.00 sec)
Rows matched: 1  Changed: 0  Warnings: 0
```

3.客户端2做查询操作：
```sql
mysql> select * from test where id = 1;
+----+------+------+-------+------+
| id | a    | b    | d     | c    |
+----+------+------+-------+------+
|  1 | 3333 | 666  | NULL |    1 |
+----+------+------+-------+------+
1 row in set (0.00 sec)

```

正在 被客户端1 upate 的记录(X锁阻塞)，客户端2还能无阻塞的读到，而且读到的是未更改之前的数据。

这就是 InnoDB 的辅助打得好，因为内部使用了 MVCC 机制，实现了一致性非阻塞读，大大提高了并发读写效率，写不影响读，且读到的事记录的镜像版本。


## 重复读 规避换行

写操作引入间隙锁Gap，对周围数据进行锁定。

# 参考

[Innodb中的事务隔离级别和锁的关系](https://tech.meituan.com/2014/08/20/innodb-lock.html)