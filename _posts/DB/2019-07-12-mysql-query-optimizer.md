---
layout: blog
title: MySQL查询优化器
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

## explain分析慢查询
定位到慢查询语句后，就需要看是分析SQL执行效率了。可以通过explain、show profile和trace等诊断工具来分析慢查询。

explain查看优化器优化过程中的信息
```sql
id： MySQL Query Optimizer 选定的执行计划中查询的序列号。表示查询中执行 select 子句或操作表的顺序,id值越大优先级越高,越先被执行。id 相同,执行顺序由上至下。 
select_type：查询类型，SIMPLE、PRIMARY、UNION、DEPENDENT UNION等。 
partitions: 匹配的分区：查询将匹配记录所在的分区。仅当使用partition关键字才显示该列。对于非分区表，该值是null
table：显示这一行的数据是关于哪张表的 
type：这是重要的列，显示连接使用了何种类型。从最好到最差的连接类型为const、eq_reg、ref、range、indexhe和all 
possible_keys：显示可能应用在这张表中的索引。如果为空，没有可能的索引。可以为相关的域从where语句中选择一个合适的语句 
key： 实际使用的索引。如果为null，则没有使用索引。很少的情况下，mysql会选择优化不足的索引。这种情况下，可以在select语句中使用use index（indexname）来强制使用一个索引或者用ignore index（indexname）来强制mysql忽略索引 
key_len：使用的索引的长度。在不损失精确性的情况下，长度越短越好 
ref：显示索引的哪一列被使用了，如果可能的话，是一个常数 
rows：mysql认为必须检查的用来返回请求数据的行数 
extra：关于mysql如何解析查询的额外信息。
```

explain结果字段：

| 列名            | 解释                                                         |
| --------------- | ------------------------------------------------------------ |
| id              | 查询编号                                                     |
| **select_type** | 查询类型：显示本行是简单还是复杂查询                         |
| table           | 涉及到的表                                                   |
| partitions      | 匹配的分区：查询将匹配记录所在的分区。仅当使用partition关键字才显示该列。对于非分区表，该值是null |
| **type**        | 本次查询的表链接类型                                         |
| possible_keys   | 可能选择的索引                                               |
| **key**         | 实际选择的索引                                               |
| key_len         | 被选择的索引长度：一般用于判断联合索引有多少列被选择了       |
| ref             | 与索引比较的列                                               |
| **rows**        | 预计需要扫描的行数，对InnoDB来说，这个值是估值，并不一定准确 |
| filtered        | 按条件帅选的行的百分比                                       |
| **Extra**       | 附加信息                                                     |

### select_type

| selecy_type值        | 解释                                                      |
| -------------------- | --------------------------------------------------------- |
| SIMPLE               | 简单查询（不使用关联查询或子查询）                        |
| PRIMARY              | 如果包含关联查询或子查询，则最外层的查询部分标记为primary |
| UNION                | 联合查询中第二个及后面的查询                              |
| DEPENDENT UNION      | 满足依赖外部的关联查询中第二个及以后的查询                |
| UNION RESULT         | 联合查询的结果                                            |
| SUBQUERY             | 子查询中的第一个查询                                      |
| DEPENDENT SUBQUERy   | 子查询中的第一个查询，并且依赖外部查询                    |
| DERIVED              | 用到派生表的查询                                          |
| MATERIALIED          | 被物化的子查询                                            |
| UNCACHEABLE SUBQUERY | 一个子查询的结果不能被缓存，必须重新评估外层查询的每一行  |
| UNCACHEABLE UNION    | 关联查询第二个或后面的语句属于不可缓存的子查询            |

### type 

| type值          | 解释                                                         |
| --------------- | ------------------------------------------------------------ |
| system          | 查询对象表只有一行数据，且只能用于MyISAM和Memory引擎的表，这是最好的情况 |
| const           | 基于主键或唯一索引查询，最多返回一条结果                     |
| eq_ref          | 表连接时基于主键或非NULL的唯一索引完成扫描                   |
| ref             | 基于普通索引的等值查询，或者表间等值连接                     |
| fulltext        | 全文检索                                                     |
| ref_or_null     | 表链接类型是ref，但进行扫描的索引列中包含NULL值              |
| index_merge     | 利用多个索引                                                 |
| unique_subquery | 子查询中使用唯一索引                                         |
| index_subquery  | 子查询中使用普通索引                                         |
| range           | 利用索引进行范围查询                                         |
| index           | 全索引扫描                                                   |
| All             | 全表扫描                                                     |

查询性能从上到下依次最好到最差

## Extra
| 常见值                               | 解释                                                         | 例子                                                         |
| ------------------------------------ | ------------------------------------------------------------ | ------------------------------------------------------------ |
| Using filesort                       | 将用外部排序而不是索引排序，数据较小时从内存排序，否则需要在磁盘完成排序 | explain select * from t1 order by create_time                |
| Using temporary                      | 需要创建一个临时表来存储结构，通常发生对没有索引的列进行group by时 | explain select * from t1 group by create_time;               |
| Using index                          | 使用覆盖索引                                                 | explain select a from t1 where a=111;                        |
| Using where                          | 使用where语句来处理结果                                      | explain select * from t1 where create_time='2019-06-18';     |
| Impossible WHERE                     | 对where子句判断的结果总是false而不能选择任何数据             | explain select * from t1 where 1<0;                          |
| Using join buffer(Block Nested Loop) | 关联查询中，被驱动表的关联字段没索引                         | explain select * from t1 straight_join t2 on (t1.create_time=t2.create_time); |
| Using index condition                | 先条件过滤索引，再查数据                                     | explain select * from t1 where a>900 and a like "%9":        |
| Select tables                        | 使用某些聚合函数（如MAX、MIN）来访问存在索引的某个字段时     | explain select max(a) from t1;                               |



查询分区执行情况：

```mysql
explain partitions SELECT * FROM `p_data` where `date` >='2020-09-01' and `date` <= "2020-09-26"
```

# 执行过程

逻辑优化，主要功能是基于关系代数以及启发式规则，找出SQL语句等价的变换形式，使得SQL执行更高效；

物理优化，即根据代价估算模型，选择最优的表连接顺序以及数据访问方式，这个阶段依赖于对数据的了解。

https://zhuanlan.zhihu.com/p/56790651
