---
layout: blog
title: 数据库优化
categories: [DB,MySQL]
description:
keywords: 索引
cnblogsClass: \[Markdown\],\[随笔分类\]数据库
---


# sql优化

## 语句优化
- 尽量避免使用子查询，如果可以使用join代替

- 避免select * 

- 很多时候用 exists 代替 in 是一个好的选择：
  select num from a where num in(select num from b);
  复制代码
  用下面的语句替换：
  select num from a where exists(select 1 from b where num=a.num);

https://www.jianshu.com/p/f212527d76ff

SQL查询中in和exists的区别分析

- limit

- order by

## 索引优化
- 尽量避免在 where 子句中对字段进行 null 值判断，否则将导致引擎放弃使用索引而进行全表扫描

  设计表时尽量设置默认值，而非null

- 尽量避免在 where 子句中使用!=或<>操作符，否则将引擎放弃使用索引而进行全表扫描

- 尽量避免在 where 子句中使用 or 来连接条件，否则将导致引擎放弃使用索引而进行全表扫描

- in 和 not in 也要慎用，否则会导致全表扫描
 
 select id from t where num in(1,2,3);
复制代码
对于连续的数值，能用 between 就不要用 in 了：

 select id from t where num between 1 and 3;


- like 查询避免前缀模糊，否则将引擎放弃使用索引而进行全表扫描
 
 select id from t where name like '%c%';

若要提高效率，可以考虑全文检索。

- 尽量避免在 where 子句中对字段进行表达式操作， 这将导致引擎放弃使用索引而进行全表扫描。

 select id from t where num/2=100;

可以这样查询：

 select id from t where num=100*2;
 
- 尽量避免在 where 子句中对字段进行函数操作，这将导致引擎放弃使用索引而进行全表扫描。

 select id from t where substring(name,1,3)='abc';#name 以 abc 开头的 id

应改为：

 select id from t where name like 'abc%';
 
- 对长度比较大的字段做索引时，应该使用前缀索引，使用一定长度作为索引

- 尽量的扩展索引而非新建索引

- 尽量使用覆盖索引，避免回表查询

- 索引不是越多越好，创建索引也是需要开销的

- 尽量使 ORDER BY 和 GROPU BY 的字段运用索引



## 数据库优化

合理用运分表与分区表提高数据存放和提取速度。