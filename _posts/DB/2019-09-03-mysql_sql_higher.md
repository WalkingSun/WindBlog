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



# INSERT INTO ... ON DUPLICATE KEY UPDATE

在INSERT语句末尾指定了ON DUPLICATE KEY UPDATE，并且插入行后会导致在一个UNIQUE索引或PRIMARY KEY中出现重复值，则在出现重复值的行执行UPDATE；如果不会导致唯一值列重复的问题，则插入新行。 


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

