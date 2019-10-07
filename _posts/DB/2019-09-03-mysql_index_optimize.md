---
layout: blog
title: 数据库优化
categories: [DB,mysql]
description: 了解下mysql优化
keywords: 索引
cnblogsClass: \[Markdown\],\[随笔分类\]数据库
oschinaClass: \[Markdown\],PHP,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---


# 定位慢查询和分析SQL执行效率

## 定位慢查询

### 慢查询日志

慢查询日志配置
```msyql
slow_query_log = 1     # 开启慢查询日志
long_query_time = 10   # 阀值时间，默认10秒
slow_query_log_file = /data/mysql/mysql-slow.log  # 慢查询日志存贮位置
log-queries-not-using-indexes = on # 记录没有使用索引的query
```

使用慢查询日志，一般分为四部：开启慢查询日志、设置查询阀值、确定慢查询日志路径、确定慢查询日志的文件名。
```mysql
mysql> set global slow_query_log = on;   
msyql> set global long_query_time = 1;   # 默认10s
msyql> show global variables like "datadir";   # 慢查询日志路径
+---------------+------------------------+
| Variable_name | Value                  |
+---------------+------------------------+
| datadir       | /data/mysql/data/3306/ |
+---------------+------------------------+
mysql> show VARIABLES like '%slow_query%';     # 慢查询日志文件名
+---------------------+----------------------------------+
| Variable_name       | Value                            |
+---------------------+----------------------------------+
| slow_query_log      | ON                              |
| slow_query_log_file | /data/mysql/data/3306/mysql-slow.log |
```

查询慢查询日志：
```shell
# 查询慢查询文件的最后5行
$ tail -n5 /data/mysql/data/3306/mysql-slow.log  
Time: 2019-05-21T09:15:06.255554+08:00

User@Host: root[root] @ localhost []  Id: 8591152

Query_time: 10.000260  Lock_time: 0.000000 Rows_sent: 1  Rows_examined: 0

SET timestamp=1558401306;
select sleep(10);
```
相应结果参数说明

- Time 慢查询发生的时间
- User@Host 客户端用户和IP
- Query_time：查询时间
- Lock_time 等待表锁的时间
- Rows_sent 语句返回的行数
- Rows_examined 语句执行期间从存储引擎读取的行数

### show processlist查询正在执行的慢查询
有时慢查询正在执行，已经导致数据库负载偏高了，而由于慢查询还没执行完，因此此时慢查询日志还看不到任何语句。
使用show proccesslist 命令判断正在执行的慢查询。

show processlist 显示哪些线程正在运行。如果有PROCESS权限，则可以看到所有线程。否则，只能看到当前会话的线程。
```mysql
mysql> show processlist;
+----+------+-----------+------+---------+------+------------+-------------------+
| Id | User | Host      | db   | Command | Time | State      | Info              |
+----+------+-----------+------+---------+------+------------+-------------------+
|  5 | root | localhost | NULL | Query   |    0 | starting   | show processlist  |
|  6 | root | localhost | NULL | Query   |   13 | User sleep | select sleep(100) |
+----+------+-----------+------+---------+------+------------+-------------------+
3 rows in set (0.00 sec)
```

- Time 表示执行时间
- info 表示执行语句

## explain分析慢查询
定位到慢查询语句后，就需要看是分析SQL执行效率了。可以通过explain、show profile和trace等诊断工具来分析慢查询。

explain结果字段：

列名 | 解释
---|---
id  | 查询编号
**select_type** | 查询类型：显示本行是简单还是复杂查询
table | 涉及到的表
partitions | 匹配的分区：查询将匹配记录所在的分区。仅当使用partition关键字才显示该列。对于非分区表，该值是null
**type** | 本次查询的表链接类型
possible_keys|可能选择的索引
**key** | 实际选择的索引
key_len | 被选择的索引长度：一般用于判断联合索引有多少列被选择了
ref | 与索引比较的列
**rows** | 预计需要扫描的行数，对InnoDB来说，这个值是估值，并不一定准确
filtered | 按条件帅选的行的百分比
**Extra** | 附加信息

### select_type

selecy_type值 | 解释
---|---
SIMPLE | 简单查询（不使用关联查询或子查询）
PRIMARY | 如果包含关联查询或子查询，则最外层的查询部分标记为primary
UNION | 联合查询中第二个及后面的查询
DEPENDENT UNION | 满足依赖外部的关联查询中第二个及以后的查询
UNION RESULT | 联合查询的结果
SUBQUERY | 子查询中的第一个查询
DEPENDENT SUBQUERy | 子查询中的第一个查询，并且依赖外部查询
DERIVED | 用到派生表的查询
MATERIALIED | 被物化的子查询
UNCACHEABLE SUBQUERY | 一个子查询的结果不能被缓存，必须重新评估外层查询的每一行
UNCACHEABLE UNION | 关联查询第二个或后面的语句属于不可缓存的子查询

### type 

type值 | 解释
---|---
system | 查询对象表只有一行数据，且只能用于MyISAM和Memory引擎的表，这是最好的情况
const | 基于主键或唯一索引查询，最多返回一条结果
eq_ref | 表连接时基于主键或非NULL的唯一索引完成扫描
ref | 基于普通索引的等值查询，或者表间等值连接
fulltext | 全文检索
ref_or_null |表链接类型是ref，但进行扫描的索引列中包含NULL值
index_merge | 利用多个索引 
unique_subquery | 子查询中使用唯一索引
index_subquery  | 子查询中使用普通索引 
range | 利用索引进行范围查询
index | 全索引扫描
All | 全表扫描

查询性能从上到下依次最好到最差

## Extra
常见值 | 解释 | 例子
---|---|---|
Using filesort | 将用外部排序而不是索引排序，数据较小时从内存排序，否则需要在磁盘完成排序 | explain select * from t1 order by create_time
Using temporary | 需要创建一个临时表来存储结构，通常发生对没有索引的列进行group by时  | explain select * from t1 group by create_time;
Using index | 使用覆盖索引 | explain select a from t1 where a=111;
Using where | 使用where语句来处理结果 |explain select * from t1 where create_time='2019-06-18';
Impossible WHERE | 对where子句判断的结果总是false而不能选择任何数据 | explain select * from t1 where 1<0;
Using join buffer(Block Nested Loop) | 关联查询中，被驱动表的关联字段没索引 | explain select * from t1 straight_join t2 on (t1.create_time=t2.create_time);
Using index condition | 先条件过滤索引，再查数据 | explain select * from t1 where a>900 and a like "%9":
Select tables | 使用某些聚合函数（如MAX、MIN）来访问存在索引的某个字段时 | explain select max(a) from t1;



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