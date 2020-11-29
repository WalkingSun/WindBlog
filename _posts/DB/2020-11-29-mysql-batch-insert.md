layout: blog
title: MySQL批量更新
categories: [DB,mysql]
description: 记录些mysql中遇到的知识点
keywords: 索引
cnblogsClass: \[Markdown\],\[随笔分类\]数据库
oschinaClass: \[Markdown\],PHP,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]

MySQL批量更新，相对于一个个更新，效率肯定更快，特别是在有限定时间内需要实现大批量的更新，节约很多时间成本，近期实现也遇到一些坑，做些整理总结。

实现方式：
- replace into
```mysql
replace into t (id,name) values (1,'2'),(2,'3');
```
使用的时候要注意：记录已存在是先删除再创建，所以只是更新某些字段使用这个会造成很大的数据丢失问题，切勿直接使用；

- insert into ...on duplicate key update批量更新
```mysql
insert into t (id,name) values (1,'2'),(2,'3') on duplicate key update name=values(name);;
```
这个用的也是比较多的，更新逻辑不会出现上面所说的问题；

- 批量更新
```mysql
UPDATE t
    SET name = CASE id 
        WHEN 1 THEN 3 
        WHEN 2 THEN 4 
        WHEN 3 THEN 5 
    END
WHERE id IN (1,2,3)
```

- 临时表
```mysql
create temporary table tmp(id int(4) primary key,dr varchar(50));
insert into tmp values  (0,'gone'), (1,'xx'),(m,'yy');
update t, tmp set t.dr=tmp.dr where t.id=tmp.id;
```
临时表也是一个思路。