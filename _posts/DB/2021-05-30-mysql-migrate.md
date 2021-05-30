---
layout: blog
title: MySQL大表优化方案
categories: [DB,mysql]
description: mysql大表数据量大优化方案
keywords: 索引
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

## 大表新增字段

### 直接添加
表读写不频繁，数据量较小（通常1G以内或百万以内），直接添加即可（可以了解一下online ddl的知识）。

![img](https://img2020.cnblogs.com/blog/1318551/202006/1318551-20200620112838414-56917316.png)

https://img2020.cnblogs.com/blog/1318551/202006/1318551-20200620112615794-1275521455.png

#### Online DDL主要阶段

包括3个阶段，prepare阶段，DDL执行阶段，commit阶段，rebuild方式比no-rebuild方式实质多了一个DDL执行阶段，prepare阶段和commit阶段类似。主要流程：

##### Prepare阶段：

1. 创建新的临时frm文件

2. 持有EXCLUSIVE-MDL锁，禁止读写

3. 根据alter类型，确定执行方式(copy,Online-rebuild,Online-norebuild)

4. 更新数据字典的内存对象

5. 分配row_log对象记录增量

6. 生成新的临时ibd文件

##### DDL执行阶段：

1. 降级EXCLUSIVE-MDL锁，允许读写

2. 扫描old_table的聚集索引每一条记录rec

3. 遍历新表的聚集索引和二级索引，逐一处理

4. 根据rec构造对应的索引项

5. 将构造索引项插入sort_buffer块

6. 将sort_buffer块插入新的索引

7. 处理DDL执行过程中产生的增量(仅rebuild类型需要)

##### commit阶段

1. 升级到EXCLUSIVE-MDL锁，禁止读写

2. 重做最后row_log中最后一部分增量

3. 更新innodb的数据字典表

4. 提交事务(刷事务的redo日志)

5. 修改统计信息

6. rename临时idb文件，frm文件

7. 变更完成 

### 使用pt_osc添加
表较大 但是读写不是太大，且想尽量不影响原表的读写，可以用percona tools进行添加，相当于新建一张添加了字段的新表，再降原表的数据复制到新表中，复制历史数据期间的数据也会同步至新表，最后删除原表，将新表重命名为原表表名，实现字段添加
### 先在从库添加 再进行主从切换
如果一张表数据量大且是热表（读写特别频繁），则可以考虑先在从库添加，再进行主从切换，切换后再将其他几个节点上添加字段





## 参考

Online DDL： https://dev.mysql.com/doc/refman/5.6/en/innodb-online-ddl-operations.html  