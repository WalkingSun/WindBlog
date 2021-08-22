layout: blog
title: MySQL Question  Note
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

记录些mysql中遇到的知识点，以备查阅归纳。

## 聚合

group by 多个字段，字段顺序对查询结果数据没有影响，只是record顺序不同而已；调整了字段顺序，sql的执行的分组顺序是不同的，如果是联合索引，顺序的调整有可能会导致不会命中索引。

当前索引  INDEX date_app_admin(`date`,`app_id`,`admin_id`);

```sql
EXPLAIN
SELECT
	sum( `after_discount` ) AS after_discount,
	sum( `promotion_fee` ) AS promotion_fee,
	`admin_id`,
	`date`,
	`app_id` 
FROM
	`channel_data` 
WHERE
	( `app_id` = 25 ) 
	AND ( `date` >= '2020-01-01' ) 
	AND ( `date` <= '2020-09-13' ) 
	AND ( `agent_type` NOT IN ( '7', '8' ) ) 
GROUP BY
	`date`,
	`app_id`,
	`admin_id`
```

![image-20200925174009025](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/ws2/image-20200925174009025.png)

调整顺序后

```sql
EXPLAIN
SELECT
	sum( `after_discount` ) AS after_discount,
	sum( `promotion_fee` ) AS promotion_fee,
	`admin_id`,
	`date`,
	`app_id` 
FROM
	`channel_data` 
WHERE
	( `app_id` = 25 ) 
	AND ( `date` >= '2020-01-01' ) 
	AND ( `date` <= '2020-09-13' ) 
	AND ( `agent_type` NOT IN ( '7', '8' ) ) 
GROUP BY
	`admin_id`,
	`app_id`,
	`date`
```

![image-20200925174209745](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/ws2/image-20200925174209745.png)