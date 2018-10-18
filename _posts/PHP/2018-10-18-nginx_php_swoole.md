---
layout: post
title: Nginx+PHP+Swoole安装记录
categories: [PHP,Swoole ]
description:
keywords: php, session
---
领了台阿里服务器1vCPU 1G，做下测试研究。
系统 centos7，使用yum安装。
# Nignx
```
yum install nginx
##开启nginx
service nginx start
```

# 安装php72
安装前确定下系统是否有安装php，有请卸载：
```
$ yum remove php   //不感觉卸载
$ rpm -qa|grep php  //显示php包 依次卸载，遇到依赖，先卸载依赖
#如 rpm -e php-mysql-5.1.6-27.el5_5.3
```
安装：
```
# yum install epel-release
//更换yum源
rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm

rpm -Uvh https://mirror.webtatic.com/yum/el7/webtatic-release.rpm

//查看
yum search php71w

//安装php以及扩展
yum install php71w php71w-fpm php71w-cli php71w-common php71w-devel php71w-gd php71w-pdo php71w-mysql php71w-mbstring php71w-bcmath

//开启服务
service php-fpm start
```

安装pecl （参考https://www.jianshu.com/p/8490cdfbafb0）
```
# curl -o go-pear.php http://pear.php.net/go-pear.phar
# php go-pear.php
//查看pecl是否安装成功  (到php目录运行 /etc/bin/)
#pecl -V
Warning: Invalid argument supplied for foreach() in Command.php on line 249

Warning: Invalid argument supplied for foreach() in /usr/share/pear/PEAR/Command.php on line 249

Warning: Invalid argument supplied for foreach() in Command.php on line 249

Warning: Invalid argument supplied for foreach() in /usr/share/pear/PEAR/Command.php on line 249

Warning: Invalid argument supplied for foreach() in Command.php on line 249

Warning: Invalid argument supplied for foreach() in /usr/share/pear/PEAR/Command.php on line 249

Warning: Invalid argument supplied for foreach() in Command.php on line 249
...
//解决办法
#vim /usr/bin/pecl
//找到下面这句
---------------------------------------------------------------------------------------------------------------------------------------------
exec $PHP -C -n -q $INCARG -d date.timezone=UTC -d output_buffering=1 -d variables_order=EGPCS -d safe_mode=0 -d register_argc_argv="On" $INCDIR/peclcmd.php "$@"
---------------------------------------------------------------------------------------------------------------------------------------------
//去掉-n
# pecl -V
PEAR Version: 1.10.5
PHP Version: 7.1.8
Zend Engine Version: 3.1.0
Running on: Linux localhost.localdomain 3.10.0-693.2.2.el7.x86_64 #1 SMP Tue Sep 12
```

# swoole安装
安装gcc
```
 yum install glibc-headers

 yum install gcc-c++
```
安装
```
pecl install swoole
```
![image](https://note.youdao.com/yws/res/41627/WEBRESOURCE2be1e463266f78e2860c45b635fb9d0d)


前往php.ini添加swoole.so ,php -m 显示安装扩展成功！
![image](https://note.youdao.com/yws/res/41632/WEBRESOURCE493f459d63cc94d47f967b1556fadc60)