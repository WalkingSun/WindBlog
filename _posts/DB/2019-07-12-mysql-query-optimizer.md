---
layout: blog
title: MySQL查询优化器【draft】
categories: [数据库]
description: 理解概念
keywords: 查询优化器
cnblogsClass: \[Markdown\],\[随笔分类\]数据库
oschinaClass: \[Markdown\]
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---


# 查询优化器 Optimizer
查询优化器的任务是发现执行SQL查询的最佳方案。

explain查看优化器优化过程中的信息
```sql
id： MySQL Query Optimizer 选定的执行计划中查询的序列号。表示查询中执行 select 子句或操作表的顺序,id值越大优先级越高,越先被执行。id 相同,执行顺序由上至下。 
select_type：查询类型，SIMPLE、PRIMARY、UNION、DEPENDENT UNION等。 
table：显示这一行的数据是关于哪张表的 
type：这是重要的列，显示连接使用了何种类型。从最好到最差的连接类型为const、eq_reg、ref、range、indexhe和all 
possible_keys：显示可能应用在这张表中的索引。如果为空，没有可能的索引。可以为相关的域从where语句中选择一个合适的语句 
key： 实际使用的索引。如果为null，则没有使用索引。很少的情况下，mysql会选择优化不足的索引。这种情况下，可以在select语句中使用use index（indexname）来强制使用一个索引或者用ignore index（indexname）来强制mysql忽略索引 
key_len：使用的索引的长度。在不损失精确性的情况下，长度越短越好 
ref：显示索引的哪一列被使用了，如果可能的话，是一个常数 
rows：mysql认为必须检查的用来返回请求数据的行数 
extra：关于mysql如何解析查询的额外信息。
```

# 执行过程

逻辑优化，主要功能是基于关系代数以及启发式规则，找出SQL语句等价的变换形式，使得SQL执行更高效；

物理优化，即根据代价估算模型，选择最优的表连接顺序以及数据访问方式，这个阶段依赖于对数据的了解。

https://zhuanlan.zhihu.com/p/56790651
