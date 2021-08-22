---
layout: blog
title: redis批量获取多个string key的set命令
categories: [redis, 事务]
description: 了解redis的数据结构，应用场景
keywords: redis, 事务, 乐观锁
cnblogsClass: \[Markdown\],\[随笔分类\]服务器,\[随笔分类\]数据库
oschinaClass: \[Markdown\],数据库,服务器,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

## 场景

记录下开发中测试数据遇到的问题，开发环境想全量跑下数据验证数据的正确性，但每个账户的token存贮在redis中string类型，格式如：```set TOKEN_{account_id}```，一个个获取要崩溃啊。我想获取到所有的账户，设置到开发环境中比较费事。

## 操作

- 先获取线上的token

```shell
# 获取到所有的token keys
scan 0 match TOKEN_* 1000

# 根据keys获取所有的值
mget TOKEN_1 TOKEN_2 ...
```

- 得到所有的set命令

  新建t.php文件

  ```php
  <?php
  
  $keys = ["TOKEN_16875607","TOKEN_19099247","TOKEN_14209713","TOKEN_17104161","TOKEN_17278520","TOKEN_9085127"];
  $values = ["11d2d1fbd4b791578228987bd36e5813","a47cb64cd5b11b4ea3826b888d281440","180ce74f55136526667539aa57392554","3014cbf71a47e24d777017e3c8a7108e","da530dcb719b68d0c27006b269637580"];
  
  foreach ($keys as $k=>$v){
      if(!$values[$k]) continue;
      echo "SET {$v} {$values[$k]}\n";
  }
  ```

  执行```php t.php >> t.txt 2>&1```,从t.txt中复制set命令在开发环境redis客户端执行。
