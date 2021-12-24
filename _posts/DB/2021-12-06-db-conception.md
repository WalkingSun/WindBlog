---
layout: blog
title: 数据库相关概念
categories: [DB]
description: 数据库相关概念
keywords: OLAP, OTAP
---

OLTP的全称是On-line Transaction Processing，中文名称是联机事务处理。其特点是会有高并发且数据量级不大的查询，是主要用于管理事务（transaction-oriented)的系统。

OLAP的全称是 On-line Analytical Processing,中文名称是联机分析处理。其特点是查询频率较OLTP系统更低，但通常会涉及到非常复杂的聚合计算。 

区别：
![20211206133002](https://raw.githubusercontent.com/WalkingSun/BigdataDocument/main/images/ws2/20211206133002.png)

OLAP分类:ROLAP,MOLAP,HOLAP 根据存储数据方式不同划分

（1）ROLAP  RelationalOLAP  关系OLAP—数据存储在RDMS中

（2）MOLAP MultidimensionalOLAP 多维OLAP—数据存储在multidimensional cube中

（3）HOLAP  HybridOLAP  混合型OLAP    尚无明确定义-根据不同场景变化

¬
# Refer
OLTP与OLAP https://www.jianshu.com/p/3c5ecfbc28d1