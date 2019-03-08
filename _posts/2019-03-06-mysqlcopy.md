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

# 概念
Mysql主从工作示意图：

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/WX20190308-150553@2x.png)


# 实施
1. 在每台服务器添加复制账号
2. 配置主库和从库，配置二进制文件地址等。
3. 同志备库连接连接到主库并启用复制

## 环境
mysql版本8.0.5,使用docker模拟，docker-compose配置如下：

```
mysql_master:
      image:  mysql:latest
      ports:
        - "3306:3306"
# hostname 当前容器内可使用        
      hostname: msmaster
      volumes:
        - /data/conf/mysql/conf:/etc/mysql/conf.d
        - /data/conf/mysql/data:/var/lib/mysql
      environment:
            MYSQL_ROOT_PASSWORD: 123456
 mysql_slave:
      image:  mysql:latest
# links 当前容器与mysql_master建立连接，容器内/etc/hosts，可以查看到mysql_master的ip配置
      links:
         - mysql_master:mysql_master
      ports:
        - "3307:3306"
      hostname: msslave
      volumes:
        - /data/conf/mysql_slave/conf:/etc/mysql/conf.d
        - /data/conf/mysql_slave/data:/var/lib/mysql
      environment:
            MYSQL_ROOT_PASSWORD: 123456

```


## 创建复制账号 
mysql主服务器为从库创建账户

```
#创建账户 为了方便，没有填从库具体域名，%任意
CREATE USER 'repl'@'%' IDENTIFIED BY 'p4ssword';

#编码方式
alter user 'repl'@'%' IDENTIFIED with mysql_native_password  by 'p4ssword';

#分配权限 *.* 代表 库名.表名（*代表全部）
GRANT REPLICATION SLAVE,REPLICATION CLIENT ON *.* TO 'repl'@'msslave';

```

mysql从服务器为主库创建账户

```
#创建账户
CREATE USER 'repl'@'mysql_master' IDENTIFIED BY 'p4ssword';

alter user 'repl'@'mysql_master' IDENTIFIED with mysql_native_password  by 'p4ssword';

#分配权限 *.* 代表 库名.表名（*代表全部）
GRANT REPLICATION SLAVE,REPLICATION CLIENT ON *.* TO 'repl'@'msmaster';

```

从库配置账号的目的，为方便提供主从切换。

## 配置主库从库
配置文件下 /mysql/conf/ /mysql_slave/conf/

master
```
[mysqld]
log_bin      = mysql-bin
server_id    = 10  #设置server-id，必须唯一
```


slave
```
log_bin           = mysql-bin
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
MASTER_LOG_POS=0;    #设置0，从日志开头读起

```

查看从库状态：
SHOW SLAVE STATUS\G;

![image](https://raw.githubusercontent.com/WalkingSun/WindBlog/gh-pages/images/blog/WX20190307-160133@2x.png)


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
```
*************************** 2. row ***************************
     Id: 7
   User: repl
   Host: 172.17.0.6:51074
     db: NULL
Command: Binlog Dump
   Time: 2978
  State: Master has sent all binlog to slave; waiting for more updates
   Info: NULL
```

配置成功！

## 从另一个服务器开始复制
主从复制已经配置好，主库修改数据，从库拉去二进制文件发生错误： Last_SQL_Error: Error executing row event: 'Unknown database 'jump''，原因在复制之前主从数据库数据不一致。

需要初始化备库，或者从其他服务器克隆数据到备库。




## 遇到问题
1） mysql8 root无grant权限，必须先建账户，再赋权限

```
CREATE USER 'root'@'%' IDENTIFIED BY '123456';
GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' WITH GRANT OPTION;
```
2） Last_IO_Error: error connecting to master 'repl@mysql_master:3306' - retry-time: 60  retries: 1
网络不通，检查hosts是否存在

