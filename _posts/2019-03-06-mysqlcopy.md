---
layout: blog
title: mysql主从复制【draft】
categories: [mysql, 数据库]
description: 了解下mysql主从复制的背景，概念，使用流程
keywords: 主从复制, mysql
cnblogsClass: \[Markdown\],\[随笔分类\]服务器,\[随笔分类\]架构,\[随笔分类\]数据库
oschinaClass: \[Markdown\],数据库,服务器,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

<!--
title内容带draft标识草稿

cnblogsClass: 【你的博客园的分类，以逗号分隔，注意\[Markdown\]必须项】
oschinaClass: 【你的开源中国的分类】
csdnClass: 【你的CSDN分类】
...

注：由于'['、']'是jekyll的关键字，故在分类中请加上'\'；

可以在网站下添加操作看到你的博客分类，案列是自己的分类，需要自行修改。
添加这些分类的目的，是可以自动同步到对应的博客网站，新建博客以此模版文件复制创建markdown文件，如果你不需要，请跳过此步。


图片地址存放参考：
本地存放路径/WindBlog/gh-pages/images/blog/b.png
git上：
![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/b.png)

-->


mysql版本8.0.5,使用docker模拟，docker-compose配置如下：

```


```

**遇到坑**
mysql8 root无grant权限，必须先建账户，再赋权限

```
CREATE USER 'root'@'%' IDENTIFIED BY '123456';
GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' WITH GRANT OPTION;
```


## 创建复制账号 
mysql主服务器为从库创建账户

```
#创建账户
CREATE USER 'repl'@'mysql_slave' IDENTIFIED BY 'p4ssword';

#编码方式
alter user 'repl'@'mysql_slave' IDENTIFIED with mysql_native_password  by 'p4ssword';

#分配权限 *.* 代表 库名.表名（*代表全部）
GRANT REPLICATION SLAVE,REPLICATION CLIENT ON *.* TO 'repl'@'msslave';

```

mysql从服务器为主库创建账户

```
#创建账户
CREATE USER 'repl'@'mysql_master' IDENTIFIED BY 'p4ssword';

alter user 'repl'@'mysql_slave' IDENTIFIED with mysql_native_password  by 'p4ssword';

#分配权限 *.* 代表 库名.表名（*代表全部）
GRANT REPLICATION SLAVE,REPLICATION CLIENT ON *.* TO 'repl'@'msmaster';

```

## 配置主库从库

master
```
[mysqld]
log_bin      = mysql_bin
server_id    = 10
```


slave
```
log_bin           = mysql_bin
server_id         = 2
# 中继日志的位置和命名
relay_log         = /var/lib/mysql/mysql-relay-bin
# 允许备库将其重放的事件也记录到自身二进制文件中
log_slave_updates = 1
# 阻止任何没有特权权限的线程修改数据
read_only         = 1
```


启动复制
```
CHANGE MASTER TO MASTER_HOST='mysql_master',
MASTER_USER='repl',
MASTER_PASSWORD='p4ssword',
MASTER_LOG_FILE='mysql-bin.000001',
#设置0，从日志开头读起
MASTER_LOG_POS=0;

```

SHOW SLAVE STATUS\G;

/website/WindBlog/images/blog/WX20190307-160133@2x.png

Slave_IO_Running Slave_SQL_Running Slave_IO_State 三列显示还未开始备库复制


开启复制：
```
START SLAVE;
```

再次 SHOW SLAVE STATUS\G; 查看 Slave_IO_Running Slave_SQL_Running Slave_IO_State 可看出IO线程、SQL线程已经开启；


查看线程列表：

SHOW PROCESSLIST\G;

```shell
*************************** 3. row ***************************
     Id: 9
   User: system user
   Host: 
     db: NULL
Command: Connect
   Time: 328
  State: Connecting to master
   Info: NULL
*************************** 4. row ***************************
     Id: 10
   User: system user
   Host: 
     db: NULL
Command: Query
   Time: 328
  State: Slave has read all relay log; waiting for more updates
   Info: NULL
```
备库的IO线程和SQL线程状态；

切换到主库查看


mysql容器内 cat /etc/hosts  查看网络

遇到问题
 Last_IO_Error: error connecting to master 'repl@mysql_master:3306' - retry-time: 60  retries: 1
