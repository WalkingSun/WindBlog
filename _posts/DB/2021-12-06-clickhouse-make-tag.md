---
layout: blog
title: 打标签方案
categories: [clickhouse]
description: 实际项目方案应用
keywords: clickhouse, bitmap
---


## client
```ssh
docker run -it --rm yandex/clickhouse-client --host cc-uf61wl44q936t43kjo.ads.rds.aliyuncs.com --port 3306  -u sun  --password 222
```

clickhouse 物化视图应用：https://www.cnblogs.com/zlt2000/p/14626156.html

https://clickhouse.com/docs/zh/engines/table-engines/mergetree-family/aggregatingmergetree/

`物化视图(Materialized View)` 与普通视图不同的地方在于它是一个查询结果的数据库对象(持久化存储)，非常趋近于表；物化视图是数据库中的预计算逻辑+显式缓存，典型的空间换时间思路，所以用得好的话，它可以避免对基础表的频繁查询并复用结果，从而显著提升查询的性能。

应用场景：基础表的数据量比较大，想利用物化视图，提前预计算数据，减少查询sql的是时间

在传统关系型数据库中，Oracle、PostgreSQL、SQL Server等都支持物化视图，而作为MPP数据库的ClickHouse也支持该特性。

ClickHouse中的物化视图可以挂接在任意引擎的基础表上，而且会自动更新数据，它可以借助 MergeTree 家族引擎(SummingMergeTree、Aggregatingmergetree等)，得到一个实时的预聚合，满足快速查询；但是对 **更新** 与 **删除** 操作支持并不好，更像是个插入触发器。

创建语法：

```sql
CREATE [MATERIALIZED] VIEW [IF NOT EXISTS] [db.]table_name [TO[db.]name] [ENGINE = engine] [POPULATE] AS SELECT ...
```





物化视图的数据更新：

1. 1.物化视图创建好之后，若源表被写入新数据则物化视图也会同步更新
2. POPULATE 关键字决定了物化视图的更新策略：
     若有POPULATE 则在创建视图的过程会将源表已经存在的数据一并导入，类似于 create table ... as 
     若无POPULATE 则物化视图在创建之后没有数据，只会在创建只有同步之后写入源表的数据.
   clickhouse 官方并不推荐使用populated，因为在创建物化视图的过程中同时写入的数据不能被插入物化视图。

3.物化视图不支持同步删除，若源表的数据不存在（删除了）则物化视图的数据仍然保留





如果创建物化视图materializ view（或视图view）的数据是由两表join产生的，那么物化视图仅有在左表插入数据时才更新。如果只有右表插入数据，则不更新。

## 同步更新和删除：

如果表数据不是只增的，而是有较频繁的删除或修改（如接入changelog的表），物化视图底层需要改用CollapsingMergeTree/VersionedCollapsingMergeTree，**其他引擎是不能做到同步更新和删除的**





```​
A materialized view is implemented as follows: when inserting data to the table specified in `SELECT`, 
part of the inserted data is converted by this `SELECT` query, and the result is inserted in the view.

Important
Materialized views in ClickHouse are implemented more like insert triggers. If there’s some aggregation in the view query, it’s applied only to the batch of freshly inserted data.
 Any changes to existing data of source table (like update, delete, drop partition, etc.) doesn’t change the materialized view.</pre>
```

简单翻译一下就是：物化视图本质就像insert语句的触发器；如果有什么集合的运算，他会应用于最新插入的数据当中；对于其他原表的变化，比如说，更新，删除，删除分区，都不会影响到物化视图的变化

```
A `SELECT` query can contain `DISTINCT`, `GROUP BY`, `ORDER BY`, `LIMIT`… Note that the corresponding conversions are performed independently on each block of inserted data.
   For example, if `GROUP BY` is set, data is aggregated during insertion, but only within a single packet of inserted data. 
The data won’t be further aggregated. The exception is when using an `ENGINE` that independently performs data aggregation, such as `SummingMergeTree`.
```

查询语句可以包含distinct，group by ,order by ,limit,特别注意这些相关联的约束只能应用于每个新插入的数据块中；比如说，如果设置了group by ,这些语句只会应用于新插入的的数据当中，不会作用于已经插入的分区当中；



http://wiki.km.com/pages/viewpage.action?pageId=30803834





聚合函数**组合器** https://clickhouse.com/docs/zh/sql-reference/aggregate-functions/combinators/



Reference

https://bohutang.me/2020/08/31/clickhouse-and-friends-materialized-view/

https://www.modb.pro/db/61195



