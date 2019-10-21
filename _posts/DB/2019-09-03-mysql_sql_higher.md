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

