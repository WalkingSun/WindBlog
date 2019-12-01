---
layout: blog
title: 抢购架构设计分析【draft】
categories: [cate1, cate2]
description: some word here
keywords: keyword1, keyword2
cnblogsClass: \[Markdown\],\[随笔分类\]架构
oschinaClass: \[Markdown\]
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

# 表结构

## 商品信息表
```sql
CREATE TABLE `ms_goods`(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品ID',
  `active_id` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '活动ID',
  `title` VARCHAR(255) NOT  NULL comment '商品名称',
  `description` text not null comment '描述信息，文本，要支持HTML',
  `price_normal` int(10) unsigned not  null DEFAULT 0 comment '原价',
  `price_discount` int(10) unsigned not null default 0 comment '秒杀价',
  `num_total` int(10) unsigned not null DEFAULT 0 comment '总数量',
  `num_user` int(10) unsigned not null default 1 comment '单个用户限购数量',
  `num_left` int(11) not null DEFAULT 0 comment '剩余可购买数量',
  `sys_darteline` int(11) not null DEFAULT 0 comment  '信息创建时间',
  `sys_lastmodify` int(11) not null DEFAULT 0 comment '最后修改时间',
  `sys_status` int(11) not null DEFAULT 0 comment '状态 0 待上线，1 一上线，2 已下线',
  `sys_ip` varchar(50) not null comment  '创建人ip',
  PRIMARY KEY (`id`)
)engine=InnoDB auto_increment=4 DEFAULT charset=utf8 comment='商品信息表';
```

## 日志记录表
```sql
CREATE table `ms_log` (
  `id` int(10) unsigned not null auto_increment comment '日志id',
  `active_id` int(10) unsigned not null comment '活动id',
  `uid` int(10) unsigned not null comment '用户id',
  `action` varchar(50) not null default '' comment  '操作名称',
  `result` varchar(50) not null default '' comment '返回信息',
  `info` text not null comment '操作详情，JSON格式保存',
  `sys_darteline` int(11) not null DEFAULT 0 comment  '信息创建时间',
  `sys_lastmodify` int(11) not null DEFAULT 0 comment '最后修改时间',
  `sys_status` int(11) not null DEFAULT 0 comment '状态 0 正常，1 异常，2 已处理的异常',
  `sys_ip` varchar(50) not null comment  '创建人ip',
  PRIMARY KEY (`id`)
)engine=InnoDB auto_increment=4 DEFAULT charset=utf8 comment='秒杀的详细操作日志';
```

## 问答信息表
```sql
create table `ms_question`(
  `id` int(11) not null auto_increment comment '问答ID',
  `active_id` int(10) unsigned not null default 0 comment '所属活动ID'，
  `title` varchar(255) not null comment '问题描述',
  `ask1` varchar(255) not null commemt '问题1',
  `answer1` varchar(255) not null comment '答案1',
  `ask2` varchar(255) not null commemt '问题2',
  `answer2` varchar(255) not null comment '答案2',
  `ask3` varchar(255) not null commemt '问题3',
  `answer3` varchar(255) not null comment '答案3',
  `ask4` varchar(255) not null commemt '问题4',
  `answer4` varchar(255) not null comment '答案4',
  `ask5` varchar(255) not null commemt '问题5',
  `answer5` varchar(255) not null comment '答案5',
  `ask6` varchar(255) not null commemt '问题6',
  `answer6` varchar(255) not null comment '答案6',
  `ask7` varchar(255) not null commemt '问题7',
  `answer7` varchar(255) not null comment '答案7',
  `ask8` varchar(255) not null commemt '问题8',
  `answer8` varchar(255) not null comment '答案8',
  `ask9` varchar(255) not null commemt '问题9',
  `answer9` varchar(255) not null comment '答案9',
  `ask10` varchar(255) not null commemt '问题10',
  `answer10` varchar(255) not null comment '答案10',
  `sys_darteline` int(11) not null DEFAULT 0 comment  '创建时间',
  `sys_lastmodify` int(11) not null DEFAULT 0 comment '最后修改时间',
  `sys_status` int(11) not null DEFAULT 0 comment '状态 0 正常 1 删除',
  `sys_ip` varchar(50) not null comment  '创建人ip',
  PRIMARY KEY (`id`)
)engine=InnoDB auto_increment=3 DEFAULT charset=utf8 comment='问答信息表';
```
主要应对非正常刷的情况，同一个问题有10种类型问答，避免机器训练。

## 订单信息表

```sql
create table `ms_trade`(
    `id` int(10) unsigned not null comment '订单ID',
    `active_id` int(10) unsigned not null comment '活动ID',
    `goods_id` int(10) unsigned not null comment  '商品ID',
    `num_total` int(10) unsigned not null default 1 comment '购买的单品数量',
    `num_goods` int(10) unsgned not null default 0 comment '购买的商品种类数量'
    `peice_total` decimal(10,0) unsigned not null default 0 comment '订单总金额',
    `price_discount` decimal(10,0) unsigned not null default 0 comment '优惠总金额',
    `time_comfirm` int(10) unsigned not null default 0 comment '确认订单时间',
    `time_pay` int(10) unsigned not null default 0 comment '支付时间',
    `time_over` int(10) unsgned not null default 0 comment '过期时间',
    `time_cancel` int(10) usigned not null default  0 comment '取消时间',
    `goods_info` mediutext not null comment  '订单商品详情，JSON格式',
    `sys_darteline` int(11) not null DEFAULT 0 comment  '创建时间',
    `sys_lastmodify` int(11) not null DEFAULT 0 comment '最后修改时间',
    `sys_status` int(11) not null DEFAULT 0 comment '状态 0 初始状态，1 待支付，2 已支付，3 已过期，4 管理员已确认，5 已取消，6 已删除，7 已发货，8 已收获，9 已完成',
    `sys_ip` varchar(50) not null comment  '用户ip',
    `uid` int(10) unsigned not null comment '用户ID',
    `username` varchar(50) not null comment  '用户名',
    PRIMARY KEY (`id`),
    KEY  `uid`(`uid`),
    KEY `active_id`(`active_id`),
    KEY `goods`(`goods`)
)engine=InnoDB  DEFAULT charset=utf8 comment='订单信息表';

```

