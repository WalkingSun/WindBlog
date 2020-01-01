---
layout: blog
title: mysql高级用法【draft】
categories: [DB,mysql]
description: 了解下mysql高级用法
keywords: 索引
cnblogsClass: \[Markdown\],\[随笔分类\]数据库
oschinaClass: \[Markdown\],PHP,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---


# replace into 用法（insert into 的增强版）
跟insert into功能类似

replace into 首先尝试插入数据到表中，
1. 如果发现表中已经有此行数据（根据主键或者唯一索引判断）则先删除此行数据，然后插入新的数据。
2. 否则，直接插入新数据。

要注意的是：插入数据的表必须有主键或者是唯一索引！否则的话，replace into 会直接插入数据，这将导致表中出现重复的数据。

MySQL replace into 有三种形式：
```sql
replace into tbl_name(col_name, ...) values(...)
replace into tbl_name(col_name, ...) select ...
replace into tbl_name set col_name=value, ...
```

# INSERT INTO ... ON DUPLICATE KEY UPDATE

在INSERT语句末尾指定了ON DUPLICATE KEY UPDATE，并且插入行后会导致在一个UNIQUE索引或PRIMARY KEY中出现重复值，则在出现重复值的行执行UPDATE；如果不会导致唯一值列重复的问题，则插入新行。 


## 情景：
实时数据的更新，如果有新的渠道则插入数据，如果渠道数据已经存在，则更新数据，如果是新增数据，则直接覆盖，如果是时长和次留数据就需要累加更新

### 方法一：

replace into tablename (f1, f2, f3) values(vf1, vf2, vf3),(vvf1, vvf2, vvf3)


自动查询主键或唯一索引冲突，如有冲突，会先删除原有的数据记录，然后执行插入新的数据，影响行数2

对于不能覆盖的数据此方法不适用

### 方法二
INSERT INTO table (a,b,c) VALUES (1,2,3)
  ON DUPLICATE KEY UPDATE c=c+1;


在insert时判断是否已有主键或唯一索引重复，如果有，一句update后面的表达式执行更新，否则，执行插入

性能分析
在数据库数据量很少的时候，　这两种方式都很快

在数据量大的时候，replace的操作要比insert on duplicate的操作低太多太多，

replace慢的原因,在更新数据的时候，要先删除旧的，然后插入新的，在这个过程中，还要重新维护索引，所以速度慢

insert on duplicate 的更新操作虽然也会更新数据，但其对主键的索引却不会有改变，也就是说，insert　on duplicate　更新对主键索引没有影响.因此对索引的维护成本就低了一些

示例：
```sql
INSERT INTO `new_duration` (`channel_name`, `date`, `channel_id`, `u_19`, `click`, `imei_new`, `android_new`, `oaid_new`, `ip_new`, `d_15`, `launch`) 
VALUES ('qm-gdtsdmpjc2_lf', '2019-12-26', 13792, 1, 0, 1, 0, 0, 0, 1200, 12) 
ON DUPLICATE KEY UPDATE 
`u_19`=VALUES(`u_19`) ,`d_15`= `d_15`+VALUES(`d_15`), `launch`= `launch`+VALUES(`launch`), `click`=0,`imei_new`=1,`android_new`=0,`ip_new`=0,`oaid_new`=0;
```

# case when then else end
Case具有两种格式。简单Case函数和Case搜索函数。 

```sql
--简单Case函数 
CASE sex 
         WHEN '1' THEN '男' 
         WHEN '2' THEN '女' 
ELSE '其他' END 
--Case搜索函数 
CASE WHEN sex = '1' THEN '男' 
         WHEN sex = '2' THEN '女' 
ELSE '其他' END 
```


```sql
/*
CREATE TABLE `dmp_history_channel_version_event_uid_20190717` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `channel` varchar(50) NOT NULL COMMENT '渠道',
    `action` varchar(100) NOT NULL COMMENT '事件',
    `uid` varchar(100) NOT NULL COMMENT '用户id',
    `hitnum` int(11) DEFAULT NULL COMMENT '点击数',
    PRIMARY KEY (`id`,`action`),
    KEY `uid` (`uid`),
    KEY `channel` (`channel`)
  ) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8
  /*!50100 PARTITION BY KEY (`action`)
  PARTITIONS 1024 */;
  
INSERT INTO `dmp_history_channel_version_event_uid_20190717` VALUES (2, 'a', 'b', '1', 100);
INSERT INTO `dmp_history_channel_version_event_uid_20190717` VALUES (1, 'a', 'a', '1', 10);
  */
SELECT
SUM(CASE WHEN action in('a','b') THEN hitnum ELSE 0 END) as ad_click
FROM dmp_history_channel_version_event_uid_20190717
```

# TO_DAYS、 FROM_DAYS

TO_DAYS(date)给出一个日期 date，返回一个天数(从 0 年开始的天数)：

```sql
SELECT TO_DAYS('2020-01-01');
+-----------------------+
| TO_DAYS('2020-01-01') |
+-----------------------+
|                737790 |
+-----------------------+
1 row in set (0.00 sec)
```

FROM_DAYS 跟TO_DAYS相反的过程
```sql

 SELECT FROM_DAYS(737790);
+-------------------+
| FROM_DAYS(737790) |
+-------------------+
| 2020-01-01        |
+-------------------+
1 row in set (0.00 sec)
```

常用来划分分区：
```sql
CREATE TABLE my_range_datetime(
    id INT,
    hiredate DATETIME
) 
PARTITION BY RANGE (TO_DAYS(hiredate) ) (
    PARTITION p1 VALUES LESS THAN ( TO_DAYS('20171202') ),
    PARTITION p2 VALUES LESS THAN ( TO_DAYS('20171203') ),
    PARTITION p3 VALUES LESS THAN ( TO_DAYS('20171204') ),
    PARTITION p4 VALUES LESS THAN ( TO_DAYS('20171205') ),
    PARTITION p5 VALUES LESS THAN ( TO_DAYS('20171206') ),
    PARTITION p6 VALUES LESS THAN ( TO_DAYS('20171207') ),
    PARTITION p7 VALUES LESS THAN ( TO_DAYS('20171208') ),
    PARTITION p8 VALUES LESS THAN ( TO_DAYS('20171209') ),
    PARTITION p9 VALUES LESS THAN ( TO_DAYS('20171210') ),
    PARTITION p10 VALUES LESS THAN ( TO_DAYS('20171211') )，
    PARTITION p11 VALUES LESS THAN (MAXVALUE) 
);
-- MAXVALUE是一个无穷大的值
```

# INSERT INTO SELECT

一个表的查询字段作为另一个表的写入
```sql

INSERT INTO db1_name (field1,field2) SELECT field1,field2 FROM db2_name

```
 

  