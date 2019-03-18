---
layout: blog
title: PHP知识点【draft】
categories: [PHP, 知识点]
description: some word here
keywords: keyword1, keyword2
cnblogsClass: \[Markdown\],\[随笔分类\]PHP
oschinaClass: \[Markdown\],PHP,日常记录
csdnClass: \[Markdown\]
163Class: \[Markdown\]
51ctoClass: \[Markdown\]
chinaunixClass: \[Markdown\]
sinaClass: \[Markdown\]
---

1. 下列PHP配置项中，哪一个和安全最不相关:() 
```
A. open_basedir
B. register_globals
C. disable_functions
D. file_uploads
```

open_basedir 可将用户访问文件的活动范围限制在指定的区域 ，通常是其家目录的路径，也   可用符号 "." 来代表当前目录。注意用 open_basedir 指定的限制实际上是前缀 , 而不是目录名。   举例来说 : 若 "open_basedir = /dir/user", 那么目录 "/dir/user" 和 "/dir/user1" 都是   可以访问的。所以如果要将访问限制在仅为指定的目录，请用斜线结束路径名。例如设置成 : "open_basedir = /dir/user/" 

 

register_globals 的意思就是注册为全局变量 ，所以当 On 的时候，传递过来的值会被直接的注册为全局变量直接使用，而 Off 的时候，我们需要到特定的数组里去得到它。 1.PHP  4.2.0   版开始配置文件中    register_globals  的默认值从  on  改为  off  了，虽然你可以设置它为 On ，但是当你无法控制服务器的时候，你的代码的兼容性就成为一个大问题，所以，你最好从现在就开始用 Off 的风格开始编程。 2. 当 register_globals 打开以后，各种变量都被注入代码，例如来自  HTML  表单的请求变量。再加上  PHP  在使用变量之前是无需进行初始化的，这就使得更容易写出不安全的代码。 当打开时，人们使用变量时确实不知道变量是哪里来的，只能想当然。但是 register_globals  的关闭改变了这种代码内部变量和客户端发送的变量混杂在一起的糟糕情况。

 

disable_functions 限制程序使用一些可以直接执行系统命令的函数 ，如 system ， exec ， passthru ， shell_exec ， proc_open 等等。所以如果想保证服务器的安全，请将这个函数加到 disable_functions 里或者将安全模式打开吧

 

file_uploads ， PHP 文件上传功能记录 file_uploads 指令决定是否启用，默认值： On 。


2. 以下程序运行结果：（     ）

```php
   <?
          $str = "LAMP";
          $str1 = "LAMPBrother";
          $strc = strcmp($str,$str1);
          switch ($strc){
                 case 1:
                        echo "str > str1";
                        break;
                 case –1:
                        echo "str < str1";
                        break;
                 case 0:
                        echo "str = str1";
                        break;
                 default:
                        echo "str <> str1";
          }
   ?>
   
A. str > str1
B. str < str1
c. str = str1
D. str <> str1
```

strmp（$str1，$str2）函数的意思，比较两个字符串的大小,比较时计算了两个字符串相差（不同）字符的个数一起作为返回。结果是-7。

3. 代码运行后的输出结果为（ ）

```php
<?php
   $d=mktime(9, 12, 31, 6, 10, 2015);
    echo "创建日期是 " . date("Y-m-d h:i:sa", $d);
```
   
   A. 创建日期是 2015-06-10 09:12:31am
   
   B. 创建日期是 2015-10-06 09:12:31am
   
   C. 创建日期是 2015-10-6 9:12:31am
   
   D. 创建日期是 2015-10-06 09:12:31pm
   
```php
mktime — 取得一个日期的 Unix 时间戳;  即：时，分，秒，月，日，年。
int mktime ([ int $hour = date("H") [, int $minute = date("i") [, int $second = date("s") [, int$month = date("n") [, int $day = date("j") [, int $year = date("Y") [, int $is_dst = -1 ]]]]]]] )
```

4. 在PHP面向对象中，下面关于final修饰符描述错误的是（ ）

A. 使用final标识的类不能被继承

B. 在类中使用final标识的成员方法，在子类中不能被覆盖

C. 不能使用final标识成员属性

D. 使用final标识的成员属性，不能在子类中再次定义

```php
PHP 5 新增了一个 final 关键字。如果父类中的方法被声明为 final，则子类无法覆盖该方法。如果一个类被声明为 final，则不能被继承。
Note: 属性不能被定义为 final，只有类和方法才能被定义为 final。
```

5. getdate()函数返回的值的数据类型是：（ ）

A. 整形 B. 浮点型 C. 数组 D. 字符串

```php
调用getdate函数的返回值
Array ( [seconds] => 37 [minutes] => 34 [hours] => 15 [mday] => 19 [wday] => 3 [mon] => 8 [year] => 2015 [yday] => 230 [weekday] => Wednesday [month] => August [0] => 1439969677 )
```

6. 关于mysql_pconnect说法正确的是?( )

 A. 与数据库进行多连接 B. 与mysql_connect功能相同 C. 与＠mysql_connect功能相同 D.与数据库建立持久连接
 
```
mysql_pconnect() 函数打开一个到 MySQL 服务器的持久连接。

mysql_pconnect() 和 mysql_connect() 非常相似，虽然只多了一个P, 但有两个主要区别：

当连接的时候本函数将先尝试寻找一个在同一个主机上用同样的用户名和密码已经打开的（持久）连接，如果找到，则返回此连接标识而不打开新连接。其次，当脚本执行完毕后到 SQL 服务器的连接不会被关闭，此连接将保持打开以备以 后使用（ mysql_close() 不会关闭由 mysql_pconnect() 建立的连接）
```
