---
layout: blog
title: ClickHouse基础
categories: [DB]
description: ClickHouse基础知识
keywords: mysql
cnblogsClass: \[Markdown\],\[随笔分类\]数据库
---



## 常用命令
### 查看所有分区 

```shell 
# 查看所有分区 
SELECT  
　　database,  
　　table,  
　　partition,  
　　name,  
　　active  
FROM system.parts  
WHERE table = 'table_name'

# Clickhouse删除分区命令: 分区name  
alter table table_name DROP PARTITION '2020-05-01';
```

```shell
#查看库表容量，压缩率等  
select  
　　sum(rows) as row,--总行数  
　　formatReadableSize(sum(data_uncompressed_bytes)) as ysq,--原始大小  
　　formatReadableSize(sum(data_compressed_bytes)) as ysh,--压缩大小  
　　round(sum(data_compressed_bytes) / sum(data_uncompressed_bytes) * 100, 0) ys_rate--压缩率  
from system.parts
```



# 参考

https://www.cnblogs.com/uestc2007/p/13691538.html